## Context

Стан (перевірено в коді): футер `resources/views/partials/footer.blade.php` має `.newsletter` з `<input id="footer-email">` і `<button type="button">` без `<form>`; бекенду немає. Форма бронювання вже дає шаблон: `POST` + `throttle:*` (rate limiter у `AppServiceProvider`), `FormRequest` у `app/Http/Requests/Main`, статичний JS у `public/assets/js/reservation.js`. Адмінка — ресурсні контролери в `app/Http/Controllers/Admin/Pages` за `auth`+`verified` у `routes/auth.php`, Blade на AdminLTE, меню в `layouts/admin`. Черги, сесії, кеш — `database` driver (таблиця `jobs` є). `MAIL_MAILER=log`. Тести б'ють у dev-БД. Мотивація — у proposal.md.

## Goals / Non-Goals

**Goals:**
- Робоча підписка з double opt-in, welcome, відписка, ручні розсилки з адмінки через чергу.
- Мінімум нових залежностей, консистентність із наявним стилем коду.

**Non-Goals:**
- Автоматичний тижневий дайджест за розкладом і авто-розсилка при публікації поста (можливе наступним change; модель `Newsletter` це не блокує).
- WYSIWYG/HTML-редактор, шаблони, сегментація, відкриття/клік-трекінг, імпорт/експорт CSV.
- Зовнішні сервіси (Mailchimp, SendGrid API) — лише SMTP через Laravel Mail.
- Багатомовність листів (мова — як на сайті, англійська).

## Decisions

1. **Дві таблиці.** `subscribers` (`id`, `email` unique lowercase, `status` enum `pending|confirmed|unsubscribed`, `token` 64 символи unique, `confirmed_at`, `unsubscribed_at`, `confirmation_sent_at`, timestamps) і `newsletters` (`id`, `subject`, `body` text, `sent_at` nullable, `recipients_count`, timestamps). Альтернатива — окремий журнал відправок на кожен лист: відхилено як надмірний для MVP.
2. **Підписані URL, а не власні токени в запиті.** Підтвердження: `URL::temporarySignedRoute('newsletter.confirm', +7 days, ['subscriber'=>id])`; відписка: `URL::signedRoute('newsletter.unsubscribe', ['subscriber'=>id])` (без терміну дії — відписка має працювати з давніх листів). Дає захист від підбору й підробки без зберігання токенів у БД. Підписаний маршрут → 403 при невалідному підписі (вимога специфікації).
3. **Нормалізація email** (`trim` + `lowercase`) у `FormRequest::prepareForValidation`; унікальність гарантує unique-індекс, гонку обробляємо через `firstOrCreate`/перехоплення `UniqueConstraintViolationException` (як у бронюванні).
4. **Ідемпотентна відповідь.** Контролер завжди повертає однакове повідомлення (JSON 200 / redirect із flash) для нового, pending, confirmed email. Для confirmed листа не шлемо. Для pending — повторний лист не частіше ніж раз на 5 хв (`confirmation_sent_at`). Для unsubscribed — перевід у `pending` + новий лист.
5. **Відправка в черзі.** Confirm/welcome — `Mail::to()->queue()` (Mailable `ShouldQueue`). Розсилка — job `SendNewsletterJob` у чергу, що розбиває адресатів по одному `Mailable` на підписника (чанки по 100), і перед відправкою кожного листа перевіряє, що статус усе ще `confirmed` (сценарій «відписаний посеред розсилки»). `sent_at` і `recipients_count` ставляться атомарно при запуску; повторний запуск блокується, якщо `sent_at` вже заповнене.
6. **List-Unsubscribe.** Заголовки `List-Unsubscribe: <signed-url>` і `List-Unsubscribe-Post: List-Unsubscribe=One-Click` через `headers()` Mailable; відписка приймає і GET (сторінка з підтвердженням одразу виконує дію), і POST (one-click).
7. **Front.** Реальний `<form method="POST" action="{{ route('newsletter.subscribe') }}">` з `@csrf`, honeypot-полем (приховане CSS, `tabindex=-1`, `autocomplete=off`), кнопка `type="submit"`, блок `role="status"` для повідомлень. `public/assets/js/newsletter.js` перехоплює submit, шле `fetch` з `Accept: application/json`; валідаційні помилки — 422 JSON. Без JS — звичайний redirect back із flash (`newsletter_status`). Стилі — тільки SCSS у `resources/scss/components/_footer.scss` + `npm run scss:build` на хості; кольори/радіуси з токенів. Підключення скрипта — в `layouts/app` через `@assetv`.
8. **Маршрути.** Публічні (`routes/web.php`): `POST newsletter` (`throttle:newsletter-subscribe`, 5/хв по IP), `GET newsletter/confirm/{subscriber}` і `GET|POST newsletter/unsubscribe/{subscriber}` (`signed`). Адмін (`routes/auth.php`): `newsletter` (index підписників + історія, create/store розсилки), `POST newsletter/{newsletter}/send`, `DELETE newsletter/subscribers/{subscriber}`. Контролери тонкі; валідація у `Requests/Main/SubscribeRequest` і `Requests/Admin/NewsletterRequest`.
9. **Honeypot** обробляється у контролері: заповнене поле → той самий «успіх», без запису (не розкриваємо боту).
10. **Тести** (feature, без `RefreshDatabase`): `Mail::fake()`/`Queue::fake()`, унікальні email із префіксом тесту та очищення в `tearDown`; покриття: валідація, ідемпотентність, підтвердження/підроблений підпис/прострочення, відписка, throttle 429, honeypot, адмін-доступ гостя, відправка та заборона повтору.

## Risks / Trade-offs

- [Листи лише в лог, бо `MAIL_MAILER=log`] → у docs/`.env.example` описати реальний SMTP; для dev перевірка через `storage/logs`.
- [Без запущеного queue worker листи не підуть] → зафіксувати команду `php artisan queue:work` у CLAUDE.md/README; у fallback можна `QUEUE_CONNECTION=sync` локально.
- [Розсилка великому списку в одному job може впертися в таймаут] → чанки по 100 і окремі jobs на лист; для масштабу ресторанного сайту достатньо.
- [Спам-підписки чужих адрес] → double opt-in + throttle + honeypot; зловживання «листом підтвердження» обмежене інтервалом 5 хв на адресу.
- [Підписаний URL відписки без терміну] → компроміс за дизайном; наслідок лише відписка одного підписника.
- [Тести працюють у dev-БД] → унікальні тестові email і явне прибирання, жодних destructive-операцій.
- [Не-hand-edit CSS] → зміни лише в SCSS і компіляція на хості (Node 20+).

## Migration Plan

1. Міграції (додаткові, зворотні) → `php artisan migrate` у `workspace-84`.
2. Налаштувати `MAIL_*` у `.env`, запустити queue worker.
3. Скомпілювати SCSS на хості, закомітити `public/assets/css/**`.
4. Відкат: `php artisan migrate:rollback --step=2`; повернути футер до попередньої розмітки (git revert).

## Open Questions

- Адреса відправника й реальний SMTP-провайдер (`MAIL_FROM_ADDRESS`) — власник визначить при деплої; на код не впливає.

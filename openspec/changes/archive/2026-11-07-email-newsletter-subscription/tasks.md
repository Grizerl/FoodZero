## 1. Дані

- [x] 1.1 Міграція `create_subscribers_table` (`email` unique, `status`, `confirmed_at`, `unsubscribed_at`, `confirmation_sent_at`, timestamps) і модель `Subscriber` зі статусами та scope `confirmed()`
- [x] 1.2 Міграція `create_newsletters_table` (`subject`, `body`, `sent_at`, `recipients_count`, timestamps) і модель `Newsletter`
- [x] 1.3 Виконати міграції в `workspace-84` (`php artisan migrate`)

## 2. Публічна підписка

- [x] 2.1 `Requests/Main/SubscribeRequest`: нормалізація email (trim+lowercase), валідація формату, honeypot-поле
- [x] 2.2 Rate limiter `newsletter-subscribe` (5/хв по IP) в `AppServiceProvider`
- [x] 2.3 Публічний `NewsletterController@subscribe`: ідемпотентна логіка (new/pending/confirmed/unsubscribed), інтервал повторного листа 5 хв, honeypot, JSON і redirect-відповіді
- [x] 2.4 `confirm` (підписаний URL, 7 днів, ідемпотентно, welcome лише при першому переході в `confirmed`) і `unsubscribe` (GET і POST one-click, підписаний URL) + Blade-сторінки результату
- [x] 2.5 Mailable-и `ConfirmSubscription`, `WelcomeSubscriber` (черга, пояснення причини листа, посилання відписки) і Blade-шаблони листів
- [x] 2.6 Маршрути в `routes/web.php` (`throttle`, `signed`)

## 3. Футер і фронт

- [x] 3.1 `partials/footer.blade.php`: справжня `<form>` з `@csrf`, honeypot, `type="submit"`, блок `role="status"` для повідомлень, flash без JS
- [x] 3.2 `public/assets/js/newsletter.js`: fetch-відправка, показ успіху/помилок (422), блокування кнопки під час запиту; підключити в `layouts/app` через `@assetv`
- [x] 3.3 SCSS у `resources/scss/components/_footer.scss` для станів success/error/disabled (токени, `respond-down`); `npm run scss:build` на хості
- [ ] 3.4 Перевірити футер на всіх сторінках і ширинах через `tools/visual-audit`

## 4. Адмінка

- [x] 4.1 `Admin\Pages\NewsletterController`: index (підписники з пагінацією, лічильники за статусами, історія розсилок), create/store розсилки, `send`, видалення підписника
- [x] 4.2 `Requests/Admin/NewsletterRequest` (тема, текст обов'язкові)
- [x] 4.3 Blade-вʼю `admin/newsletter/*` у стилі наявних адмін-сторінок; пункт «Newsletter» у меню `layouts/admin` (верхнє і бокове)
- [x] 4.4 Маршрути в `routes/auth.php` за `auth`+`verified`

## 5. Розсилка

- [x] 5.1 Mailable `NewsletterCampaign` із `List-Unsubscribe`/`List-Unsubscribe-Post` та посиланням відписки в тілі
- [x] 5.2 Job `SendNewsletterJob`: вибір підтверджених, чанки по 100, перевірка статусу перед відправкою, атомарне виставлення `sent_at`/`recipients_count`, заборона повторного надсилання, повідомлення «нікому надсилати»

## 6. Тести та перевірка

- [x] 6.1 Feature-тести підписки: валідація, ідемпотентність (регістр/пробіли, повтор pending/confirmed/unsubscribed), throttle 429, honeypot (`Mail::fake`, унікальні тестові email, прибирання в `tearDown`, без `RefreshDatabase`)
- [x] 6.2 Feature-тести confirm/unsubscribe: валідний, прострочений, підроблений підпис (403), повторне відкриття, один welcome
- [x] 6.3 Feature-тести адмінки: гість не має доступу, список, створення, відправка, повторна відправка, відсутність адресатів, відписаний не отримує (`Queue::fake`/`Mail::fake`)
- [x] 6.4 Ручна перевірка end-to-end: підписка з футера → лист у `storage/logs` → підтвердження → welcome → розсилка з адмінки (worker запущено) → відписка
- [x] 6.5 `vendor/bin/pint` лише на змінених файлах; `php artisan test`

## 7. Документація

- [x] 7.1 `.env.example`: коментар про `MAIL_*` для реальної відправки і необхідність `queue:work`
- [x] 7.2 `CLAUDE.md`: короткі нотатки про підписку, чергу й маршрути

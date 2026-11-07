## Context

- Стилі — SCSS у `resources/scss/`, збірка `npm run scss:build` на хості, результат комітиться (див. `scss-styling-pipeline`). Blade не використовує `@vite`.
- Публічний лейаут `layouts/app` вантажить `index.css` + `app.css` (+ сторінковий CSS через `@yield('link.css')`). Адмін-лейаут вантажить AdminLTE 3 / Bootstrap 4 з `public/admin/**`; власних стилів адмінки немає.
- `tools/visual-audit` знімає 7 сторінок × 4 ширини і перевіряє скрол/404/`h1`/вкладені `<a>`/відступи — використовуємо як регресійну перевірку.
- Тести ходять у dev-БД: у цій зміні немає змін БД і нових деструктивних тестів.

## Goals / Non-Goals

**Goals**
- Сучасний вигляд публічного сайту й адмінки в тій самій оливково-зеленій гамі.
- Адаптивність 375 / 768 / 1024 / 1440 px без горизонтального скролу й перекриттів.
- Логотип веде на головну сторінку сайту.
- Жодного `Lorem ipsum`; усі видимі підписи — англійською.

**Non-Goals**
- Нова гама, нові шрифти, JS-фреймворк, Vite/Tailwind для Blade.
- Заміна AdminLTE, правки у `public/admin/dist|plugins/**`.
- Нова функціональність (розсилка лишається візуальною формою, як і була).
- Зміни схеми БД, маршрутів і структури API-відповідей.

## Decisions

**1. Еволюція токенів, не нова гама.** Колір-токени `$color-main`, `$color-surface`, `$color-accent`, `$color-accent-hover` лишаються. Додаємо `$color-main-deep #1a2400` (низ градієнта), `$color-ink #16200a` (текст на світлому замість чистого чорного), радіуси `sm/md/lg/pill` (вже є), `$shadow-soft`. Наявні CSS-змінні (`--background-color-main`, `--color-navbar-text` …) зберігаються — на них спираються Blade-шаблони; додаємо `--gutter` і `--space-section`.
*Альтернатива:* перейменувати змінні — зайвий ризик регресій без користі.

**2. Контейнер і ритм.** `.container { width: min(100% - 2 * var(--gutter), 1240px); margin-inline: auto }`, `--gutter: clamp(16px, 4vw, 40px)`, `--space-section: clamp(56px, 8vw, 112px)`. Секції беруть вертикальні відступи з токена, а не з десятка різних `padding-top: 70/90/50px`.

**3. Типографіка.** Заголовки — Rufina, `line-height: 1.1–1.2`, `fluid-type`; тіло — Lato 17–18 px, `line-height: 1.7`; UI (кнопки, телефон, підписи) — Inter. Hero 85 → 72 px, h1 55 → 48 px.

**4. Шапка.** `<header class="site-header">` стає `position: sticky; top: 0`, фон `rgba($color-main, .86)` + `backdrop-filter: blur(12px)` з суцільним fallback у `@supports not`. Висота 72 px (64 px на мобільному). Логотип: `<a class="site-logo" href="{{ route('home.page') }}" aria-label="FoodZero — home">` із вбудованим SVG-листком і словом «FoodZero». Бургер-меню лишається повноекранним оверлеєм, z-index вищий за шапку.

**5. Hero і секції головної.** Hero — дві колонки (текст + фото із `$radius-lg`), під фото — ряд спецій на «скляних» плашках; текстова колонка отримує CTA. «Start to plan your diet today» — два блоки фото+текст у сітці; «Our Menu», «Excellent cook», «Premium Quality…» — та сама розмітка, нові стилі й тексти; «Calories Energy Balance» — плитки із заокругленням і градієнтом знизу, назва внизу; слайдер — картка з тінню й круглим аватаром. Розмітка змінюється мінімально (шапка, футер, hero-CTA, тексти), решта — SCSS.

**6. Форма бронювання.** `partials/form.blade.php` — світла картка (`#fff`, `$radius-lg`, тінь). Поля в `grid` з `repeat(auto-fit, minmax(220px, 1fr))`, кожне з `<label>`. Інлайнові `style=""` у помилках → `.form-error` / `.form-success`. Кнопка — `<button class="btn btn--primary">Book now</button>` (прибираємо невалідне `<button><a>`).

**7. Кнопки.** Єдиний компонент `components/_buttons.scss`: `.btn`, `.btn--primary`, `.btn--light` (на темному), `.btn--ghost`; hover/active/`focus-visible` (міксин `focus-ring`), `transition` з `reduce-motion`. Наявні `.btn-reservations`, `.btn-reservation`, `.email-button`, `.menu-cta`, `.btn_map` переводяться на нього.

**8. Футер.** Окремий `components/_footer.scss` (зараз — у `app.scss`): колонки `1.3fr 1fr 1fr 1.3fr` (бренд, навігація, контакти, розсилка); ≤ `md` — дві колонки, ≤ `sm` — одна. Нижня смужка — копірайт і соцмережі.

**9. Адмінка — окремий шар поверх AdminLTE.** `resources/scss/admin.scss` → `public/assets/css/admin.css`, підключення в `layouts/admin.blade.php` після `adminlte.min.css`. Правимо `.main-header`, `.main-sidebar`, `.content-wrapper`, `.card`, `.table`, `.btn-*`, `.form-control`, `.small-box`, `.pagination`, `.alert`. Шрифт — Inter. Сайдбар у `$color-main`, активний пункт — світла плашка й акцент `$color-accent-hover`. Плитки дашборду отримують клас `.stat-card` поруч зі старими AdminLTE-класами.
*Альтернатива:* переписати 14 Blade-шаблонів адмінки — відкинуто, більшість — прості таблиці/форми, достатньо глобальної теми.

**10. Адаптив адмінки.** Таблиці прокручуються по горизонталі всередині картки (`.card-body { overflow-x: auto }`), `content-header` переноситься, на ≤ `md` кнопки дій займають повну ширину. Мобільний сайдбар — штатний `sidebar-collapse` AdminLTE, стилізується кнопка меню й оверлей.

**11. Логотип → головна.** Публічна шапка, футер і сторінка логіну: `<a href="{{ route('home.page') }}">`. У адмінці брендовий блок сайдбара веде на дашборд (її власну «головну»), а окремий пункт «View site» відкриває `route('home.page')`. Так навігація адмінки не ламається, а публічне вимога «логотип → головна» виконана.

**12. Контент.** Тексти — англійські, нейтральні й правдоподібні для ресторану зі свіжою сезонною кухнею. Відгуки — три різні тексти. У блоці команди два підписи були однаковими («Restaurant Manager / Carson Hugn») при різних фото; друга людина (файл `John.png`) отримує вигадане демо-ім'я й роль Head Chef. Українські підписи логіну й API → англійські.

**13. Рух.** Лише `transform`/`opacity`, до 0.35 с, вимикається `@include reduce-motion`. Нових JS-бібліотек немає.

## Risks / Trade-offs

- **Масштаб SCSS (≈3600 рядків)** → правимо групами, після кожної — `visual-audit`; застарілі правила видаляємо, а не нашаровуємо.
- **Висока специфічність AdminLTE** → підключення після `adminlte.min.css`; подвоєння селектора лише за потреби.
- **`backdrop-filter` у старих браузерах** → суцільний фон як fallback.
- **Скомпільований CSS у git** → кожна правка SCSS супроводжується `npm run scss:build`.
- **Тексти суб'єктивні** → стисла нейтральна подача, щоб замовник міг замінити.

## Migration Plan

1. Гілка `feature/modern-redesign` від `develop`. 2. Токени й компоненти → шапка/футер → головна → внутрішні сторінки → форма → адмінка → логін → тексти. 3. Після кожного кроку `npm run scss:build` і візуальна перевірка. 4. Фінал: `visual-audit` на 4 ширини, `php artisan test`, `pint` на змінених PHP. Відкат — `git revert`; БД не змінюється.

## Open Questions

- Чи потрібне реальне збереження підписок на розсилку? У цій зміні — ні.
- Темний режим адмінки — не входить.

## 1. Основа: токени, кнопки, шапка, футер

- [x] 1.1 Оновити `abstracts/_tokens.scss` (`$color-main-deep`, `$color-ink`, `$shadow-soft`, `$gradient-dark`, `--gutter`, `--space-section`, `--header-height`) і `.container` в `app.scss`; перевірено: `npm run scss:build` без помилок
- [x] 1.2 Створити `components/_buttons.scss` (`.btn`, `--primary`, `--light`, `--ghost`, `--outline`, `--sm`) і перевести наявні кнопки (резервація, підписка, «Complete menu», «View in maps», «Book now»); `focus-visible` — через міксин `focus-ring`
- [x] 1.3 Шапка: `partials/header.blade.php` — `<header class="site-header">`, логотип `<a href="{{ route('home.page') }}">` з SVG-знаком, без рамки з псевдоелементів; `components/_header.scss`, липка шапка; перевірено: у HTML усіх 7 публічних сторінок логотип веде на `home.page`
- [x] 1.4 Футер: `partials/footer.blade.php` (бренд-посилання, навігація, контакти, розсилка, нижня смуга), `components/_footer.scss` (4 → 2 → 1 колонки); перевірено: 375 px без горизонтального скролу
- [x] 1.5 `components/_burger.scss` / `adaptive-menu.js`: оверлей виростає з позиції кнопки (`--menu-x/--menu-y`), z-index над шапкою; audit: бургер-меню на 375×667 — прокрутка, соцмережі досяжні, контраст кнопки закриття

## 2. Публічні сторінки

- [x] 2.1 Головна: hero (градієнт, CTA «Book a table» / «View the menu»), «Start to plan your diet today», «Our Menu», «Excellent cook», «Premium Quality / Seasonal Vegetables / Fresh Fruit»; перевірено знімками 1440 і 390
- [x] 2.2 Головна: форма бронювання (`partials/form.blade.php`: `<label>`, `.form-error`, `.form-success`, валідна кнопка), «Calories Energy Balance» (градієнтні плитки-посилання), слайдер відгуків (картка, кнопки з `aria-label`, `prefers-reduced-motion`)
- [x] 2.3 Картки страв і постів (`_dish-card`, `_post-card`) — відступи секцій з токена; hover не змінює розкладку
- [x] 2.4 Спільний `partials/page-banner` + `components/_page-banner.scss` для menu / full-menu / blog / post / about / contact; смуга «Open time» (contact, full-menu); навігація категорій і пагінація
- [x] 2.5 About (історія, команда, відео-блок, етапи процесу) і Contact (картки зв'язку), сторінка допису (хлібні крихти, стаття, цитата)

## 3. Адмінка

- [x] 3.1 `resources/scss/admin.scss` → `public/assets/css/admin.css` (шрифт Inter, шапка, сайдбар, content-wrapper); підключено в `layouts/admin.blade.php` після `adminlte.min.css`
- [x] 3.2 Картки, таблиці, форми, кнопки, пагінація, alert; плитки дашборду → `.stat-card` у `admin/dashboard.blade.php`
- [x] 3.3 Адаптив: таблиці прокручуються всередині картки, мобільні плитки, активний пункт сайдбара (`active`/`menu-open` за маршрутом), «View site» у сайдбарі й верхній панелі; перевірено 390 і 1440 px: `overflowX = 0` на dashboard, posts, menu, reservation, members, post/create
- [x] 3.4 Сторінка логіну: `auth/login.blade.php` (англійські підписи, логотип → `home.page`, посилання «Back to the website») і `auth/login.scss` у гамі бренду

## 4. Контент

- [x] 4.1 Усі `Lorem ipsum` на головній і About замінено; виправлено `alt` (`Lead`, `Bnt play`, `Brain`), підписи команди (другий учасник — Head Chef), етапи Slice / Pickled / Bake з відповідними фото, відгуки
- [x] 4.2 Англійські повідомлення в `Api/ApiController.php`; перевірено: пошук `lorem|ipsum|consectetur` і кирилиці по `resources/` та `app/` — збігів немає; у відрендереному HTML 7 публічних сторінок `lorem|ipsum` — 0

## 5. Верифікація

- [x] 5.1 `tools/visual-audit`: `audit.mjs` отримав `ROUTE_PREFIX` і `ADMIN_LOGIN_PATH` (маршрути можуть змінюватися), плитки `.tile` не рахуються декором; нові `slices.mjs` і `admin-shots.mjs` (знімки частинами, адмінка з одним входом). Результат: 0 помилок на 7 сторінках × 4 ширини + бургер. Перевірки «Lorem» і «логотип → головна» виконано окремо через `curl`/`grep`, у сам audit не додавалися
- [x] 5.2 Адмінка оглянута знімками: login, dashboard, posts, menu, post/create (1440) і dashboard, posts, reservation, members (390). Сторінки category/create/edit окремо не знімалися: вони на тих самих компонентах
- [x] 5.3 `vendor/bin/pint` на `ApiController.php`; `CLAUDE.md` оновлено. `php artisan test`: 2 з 4 тестів падають через зміну маршрутів (див. нотатку в підсумку), не через редизайн

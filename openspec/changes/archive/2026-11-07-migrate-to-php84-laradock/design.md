## Context

Див. proposal.md (Why / What Changes) щодо мотивації та результатів аналізу.

Поточний стан Laradock (`C:\projects\laradock`, `COMPOSE_PROJECT_NAME=laradock_all`):
- Кастомізований мультиверсійний стек: `php-fpm-56…84`, `workspace-80/82/84`; nginx підключає всі файли з `nginx/sites/` (префікс файлу = версія PHP, напр. `84_game4you.conf`).
- `APP_CODE_PATH_HOST=../` → `C:\projects` змонтовано в `/var/www`, отже Food Zero = `/var/www/FoodZero/zero`.
- Користувач у `workspace-84` — `laradock` (uid 1001); `git` у ньому потребує `safe.directory` для змонтованого репозиторію.
- Порти nginx: 80/443; MySQL 8.3 (`root/root`), phpMyAdmin на 8081.
- `storage` та `bootstrap/cache` вже мають права `rwx` для всіх (bind-mount з Windows).

Обмеження: Laradock — спільна інфраструктура для багатьох проєктів, тому зміни в ньому мають бути мінімальними й адитивними (один новий файл сайту).

## Goals / Non-Goals

**Goals:**
- Food Zero працює на `http://foodzero.local/` через nginx → `php-fpm-84` → MySQL `zero`.
- PHP 8.4 зафіксовано в `composer.json`/`composer.lock`; тести й смоук-перевірки проходять.
- Інструкція запуску в README відтворювана.

**Non-Goals:**
- Не оновлюємо Laravel до 13 і не міняємо мажорні версії пакетів (`phpunit 13`, `tinker 3`, `elfinder 0.6`).
- Не змінюємо бізнес-логіку, маршрути, схему БД.
- Не змінюємо спільні налаштування Laradock (`.env`, `docker-compose.yml`, версію Node у workspace).
- Не налаштовуємо збірку Vite/Node (див. Decisions).
- Не додаємо Docker-файли в репозиторій Food Zero.

## Decisions

1. **Окремий nginx-файл `84_foodzero.conf`, за зразком `84_game4you.conf`.**
   Домен `foodzero.local`, `root /var/www/FoodZero/zero/public`, `fastcgi_pass php-fpm-84:9000`, логи `foodzero-access/error.log`.
   Альтернатива — довірити роутинг `default.conf` або піддиректорії; відхилено, бо ламає ізоляцію від інших проєктів.

   **Уточнення під час виконання:** запущений nginx працює з override `docker-compose.game4you.yml`, який монтує `nginx/sites-game4you/` (а не `nginx/sites/`) і має upstream лише для `php-fpm-84`. Тому файл додано в обидві теки: `nginx/sites/84_foodzero.conf` (повний стек) і `nginx/sites-game4you/95_foodzero.local.conf` (активний стек). Префікс `95_` потрібен, щоб game4you залишався default-сервером (nginx обирає перший блок за алфавітом).

2. **Домен `foodzero.local` + запис у `hosts`.**
   Альтернатива — окремий порт у nginx (потребує змін у `docker-compose.yml`) або `localhost` (конфлікт із `default.conf`). Запис у `hosts` вимагає адмін-прав; якщо їх немає — перевіряти через `curl -H "Host: foodzero.local" http://127.0.0.1/` і попросити користувача додати рядок вручну.

3. **Підняти лише потрібні сервіси:** `docker compose up -d nginx mysql php-fpm-84 workspace-84` (+ `redis`, `phpmyadmin` за бажанням, вони вже запущені). Контейнери вже працюють, тому достатньо `docker compose exec nginx nginx -s reload` після додавання сайту.
   Альтернатива — повний `up -d` (піднімає зайві PHP-версії).

4. **Конфігурація `.env`.** Використовуємо вже наявні `DB_HOST=mysql`, `DB_DATABASE=zero`, `DB_USERNAME=root`, `DB_PASSWORD=root`; `APP_URL=http://foodzero.local`. `.env` не комітиться (є в `.gitignore`), тож у `.env.example` переносимо ті ж значення БД (замість SQLite) і `APP_URL`, без секретів.
   Сесії/кеш/черги залишаються на `database` — відповідні таблиці створюють наявні міграції `0001_01_01_*`.

5. **Фіксація PHP 8.4:** `require.php = "^8.4"` та `config.platform.php = "8.4.0"`, щоб `composer update` ніколи не підтягував пакети, несумісні з 8.4, незалежно від локальної версії.
   Альтернатива — залишити `^8.2`; відхилено, бо мета — єдина версія та гарантія, що lock зібраний саме під 8.4.

6. **Оновлення залежностей — лише `composer update` у межах constraint** (Laravel 12.x, sanctum 4.x, phpunit 11.x тощо). Це підтягує виправлення, зокрема сумісність з PHP 8.4, без мажорних змін. Мажорні оновлення (Laravel 13, phpunit 13) винесені за межі.
   Пакет `barryvdh/laravel-elfinder` залишаємо `^0.5.4` (0.6.0 — мажорний для 0.x, може мати breaking changes) і перевіряємо його роботу смоуком.

7. **Node не чіпаємо.** `resources/views` не використовує `@vite`/`mix`, асети — у `public/`. Node 16 у workspace несумісний з Vite 6, але це не впливає на запуск; фіксуємо як відоме обмеження в README.

8. **Верифікація:** `php -l` по всіх файлах, `composer validate`, `composer check-platform-reqs`, `php artisan migrate`, `php artisan test`, HTTP-смоук (`/`, `/up`, `/admin/login`, 404), перегляд `storage/logs/laravel.log` на deprecation.

## Risks / Trade-offs

- [Запис у `hosts` без прав адміністратора] → Спробувати PowerShell; при відмові дати користувачу точну команду й перевіряти через заголовок `Host`.
- [Перезавантаження nginx зачепить інші проєкти, якщо в іншому конфізі помилка] → Спершу `nginx -t`; reload лише при успіху; при помилці — видалити свій файл і розібрати причину.
- [`composer update` змінює lock і може внести регресію] → Оновлення лише в межах constraint, одразу запуск тестів і смоуку; відкат через `git checkout composer.lock composer.json` (lock під git).
- [Права/власник файлів на bind-mount з Windows (`dubious ownership`, повільний I/O)] → `git config --global --add safe.directory` у workspace; опційно використовувати opcache-налаштування Laradock (поза обсягом).
- [Підключення до MySQL: `root` для застосунку] → Прийнятно для локальної розробки; у README позначити, що це dev-значення.
- [Порожня БД `zero` + наявний `database/database.sqlite` у репо] → SQLite-файл не використовується при `DB_CONNECTION=mysql`; не видаляємо його в межах цієї зміни.
- [Зміна `.env.example` з SQLite на MySQL ламає швидкий старт без Docker] → Задокументувати в README обидва варіанти або прямо вказати Laradock як основний.

- [Виявлено під час виконання: `workspace-84` працював лише в мережі `frontend`, `mysql` — у `backend`] → `docker network connect laradock_all_backend laradock_all-workspace-84-1` (не переживає перестворення контейнера; `docker compose up -d --force-recreate workspace-84` відновить обидві мережі згідно з compose).
- [Виявлено під час виконання: токен GitHub у глобальному `auth.json` workspace недійсний] → `composer install` виконано з тимчасовим `COMPOSER_HOME` без токена; токен не змінювався, його треба оновити окремо.
- [Виявлено під час виконання: `ExampleTest` очікував 200 на `/`, а маршрут робить redirect] → тест оновлено під фактичну поведінку (redirect на `home.page`) і додано перевірки `/admin/login` та `/up`.
- [Поза обсягом, виявлено: `GET /dashboard` для гостя → 500 `Route [login] not defined`] → давня помилка застосунку (маршрут входу названо `admin.login.form`), не пов'язана з PHP 8.4; не змінювалася.

## Migration Plan

1. Додати nginx-сайт, `nginx -t`, reload nginx.
2. Додати `foodzero.local` у `hosts`.
3. У `workspace-84`: `git config safe.directory`, `composer install`, зміни в `composer.json`, `composer update`, `php artisan migrate`.
4. Оновити `.env`/`.env.example`/README.
5. Прогнати верифікацію (Decisions п. 8).

Rollback: видалити `84_foodzero.conf` і перезавантажити nginx, прибрати рядок із `hosts`, `git checkout composer.json composer.lock`, `DROP DATABASE`/`migrate:fresh` за потреби.

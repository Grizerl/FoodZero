## Why

Проєкт Food Zero (Laravel 12) зараз запускається вручну через `php artisan serve` на локальному PHP, а `composer.json` дозволяє PHP `^8.2`. Решта проєктів розробника вже працює в Laradock (`C:\projects\laradock`) з контейнерами `php-fpm-84`/`workspace-84` (PHP 8.4.27), тому Food Zero потрібно підняти в тому самому середовищі й зафіксувати PHP 8.4 як єдину підтримувану версію, щоб dev, залежності й lock-файл були узгоджені.

## What Changes

Результати аналізу (спостережено, не припущено):
- Laradock змонтовано з `APP_CODE_PATH_HOST=../`, тож проєкт доступний у контейнерах як `/var/www/FoodZero/zero`.
- `php-fpm-84` має всі потрібні розширення (`pdo_mysql`, `mbstring`, `intl`, `gd`, `bcmath`, `opcache` тощо); `composer check-platform-reqs` на 8.4.27 проходить без помилок.
- Lint `app/ bootstrap/ config/ database/ routes/ tests/` на 8.4 чистий, неявних nullable-параметрів (deprecated в 8.4) немає.
- MySQL 8.3 у Laradock має БД `zero`, але вона порожня (міграції не виконані); `.env` вже містить `DB_HOST=mysql`, `DB_DATABASE=zero`, `root/root`.
- Відсутній nginx-віртуальний хост для проєкту; запису `foodzero.local` у `hosts` немає.
- У workspace Node 16, а `vite@6`/`tailwindcss@4` вимагають Node ≥ 18; проте Blade-шаблони не використовують `@vite`, фронтенд-асети лежать у `public/`, тому збірка Vite не блокує запуск.

Зміни:
- Додати nginx-сайт `84_foodzero.conf` у Laradock (`foodzero.local` → `/var/www/FoodZero/zero/public`, upstream `php-fpm-84:9000`).
- Додати `foodzero.local` у `hosts` (потребує прав адміністратора; fallback — запит із заголовком `Host`).
- Підняти `nginx`, `mysql`, `php-fpm-84`, `workspace-84`; виконати міграції у БД `zero`.
- **BREAKING**: `composer.json` — `"php": "^8.4"` і `config.platform.php = 8.4.0`; підтримку PHP 8.2/8.3 знято.
- Оновити залежності в межах існуючих constraint (`composer update`), перегенерувати `composer.lock` під PHP 8.4.
- Оновити `.env.example` і `README.md` інструкціями запуску через Laradock/PHP 8.4.
- Перевірити дім-сторінку, адмін-логін, `/up` і запустити тести на PHP 8.4.

## Capabilities

### New Capabilities
- `laradock-environment`: Запуск і доступність застосунку через Laradock (nginx + php-fpm-84 + MySQL), хост, БД, міграції, документація запуску.
- `php-runtime-compatibility`: Застосунок і залежності вимагають та коректно працюють на PHP 8.4 без deprecation-помилок.

### Modified Capabilities

<!-- Наявних специфікацій немає (openspec/specs порожній). -->

## Impact

- Код проєкту: `composer.json`, `composer.lock`, `.env.example`, `README.md` (бізнес-логіка застосунку не змінюється).
- Поза репозиторієм: `C:\projects\laradock\nginx\sites\84_foodzero.conf`, `C:\Windows\System32\drivers\etc\hosts`.
- Інфраструктура: контейнери Laradock (`nginx`, `mysql`, `php-fpm-84`, `workspace-84`), БД `zero`.
- Залежності: мінорні/патч-оновлення пакетів у межах `laravel/framework ^12.0`, `sanctum ^4`, `tinker ^2.10`, `phpunit ^11.5`.

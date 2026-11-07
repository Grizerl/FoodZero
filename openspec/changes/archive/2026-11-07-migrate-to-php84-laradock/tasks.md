## 1. Laradock: nginx і домен

- [x] 1.1 Створити `C:\projects\laradock\nginx\sites\84_foodzero.conf` (`foodzero.local`, root `/var/www/FoodZero/zero/public`, `fastcgi_pass php-fpm-84:9000`) і перевірити, що файл існує
- [x] 1.2 Виконати `docker compose exec nginx nginx -t` і, якщо успішно, `nginx -s reload`; перевірити, що тест конфігурації повертає `syntax is ok`
- [x] 1.3 Додати `127.0.0.1 foodzero.local` у `C:\Windows\System32\drivers\etc\hosts` (або видати користувачу команду, якщо немає прав) і перевірити `curl -I http://foodzero.local/` (або з заголовком `Host`)
- [x] 1.4 Переконатися, що контейнери `nginx`, `mysql`, `php-fpm-84`, `workspace-84` запущені (`docker compose ps`)

## 2. PHP 8.4: залежності

- [x] 2.1 У `workspace-84` додати `git safe.directory` для `/var/www/FoodZero/zero` і перевірити, що `git status` працює без помилки
- [x] 2.2 Змінити `composer.json`: `"php": "^8.4"` і `config.platform.php = "8.4.0"`; перевірити `composer validate`
- [x] 2.3 Виконати `composer update` (лише в межах constraint) у `workspace-84` і перевірити, що `composer.lock` оновлено, а `composer check-platform-reqs` без помилок
- [x] 2.4 Прогнати `php -l` по `app bootstrap config database routes tests` на PHP 8.4 і перевірити відсутність виводу про помилки/deprecation

## 3. База даних і конфігурація

- [x] 3.1 Виставити в `.env` `APP_URL=http://foodzero.local`; перевірити, що `php artisan config:show app.url` показує це значення
- [x] 3.2 Виконати `php artisan migrate` у `workspace-84` і перевірити, що `php artisan migrate:status` показує всі міграції як `Ran`
- [x] 3.3 Оновити `.env.example`: MySQL (`DB_HOST=mysql`, `DB_DATABASE=zero`, `root/root`) та `APP_URL`; перевірити diff на відсутність секретів (без `APP_KEY`)
- [x] 3.4 Очистити кеші (`php artisan optimize:clear`) і перевірити, що команда завершується успішно

## 4. Документація

- [x] 4.1 Переписати розділ «Launch instructions» у `README.md` під Laradock + PHP 8.4 (запуск контейнерів, БД, `composer install`, міграції, `hosts`, примітка про Node 16) і перевірити, що кроки відповідають виконаним у цій зміні

## 5. Верифікація

- [x] 5.1 Виконати `php artisan test` у `workspace-84` і перевірити, що всі тести проходять
- [x] 5.2 Смоук-перевірка HTTP: `/` → 200, `/up` → 200, `/admin/login` → 200, неіснуючий шлях → 404; зафіксувати коди відповідей
- [x] 5.3 Переглянути `storage/logs/laravel.log` після смоуку і перевірити, що немає записів про PHP deprecations або нових помилок
- [x] 5.4 Порівняти `php artisan route:list` з версією до зміни (збережений до `composer update`) і перевірити, що набір маршрутів ідентичний

# php-runtime-compatibility Specification

## Purpose

Гарантує, що Food Zero і його залежності офіційно підтримують PHP 8.4 та працюють на ньому без помилок і deprecation-повідомлень, а середовище не дозволяє встановити їх на старішу версію.

## Requirements

### Requirement: Мінімальна версія PHP — 8.4
Проєкт SHALL декларувати PHP 8.4 як мінімально підтримувану версію, а залежності SHALL розв'язуватися для платформи PHP 8.4.

#### Scenario: Встановлення на PHP 8.4
- **WHEN** виконується `composer install` на PHP 8.4
- **THEN** встановлення завершується успішно, а `composer check-platform-reqs` не повідомляє про помилки

#### Scenario: Встановлення на старішому PHP
- **WHEN** `composer install` запускається на PHP нижче 8.4
- **THEN** Composer відмовляє з повідомленням про невідповідність версії PHP

#### Scenario: Lock-файл узгоджений з маніфестом
- **WHEN** виконується `composer validate`
- **THEN** команда повідомляє, що `composer.json` валідний і `composer.lock` актуальний

### Requirement: Код не містить несумісностей з PHP 8.4
Код застосунку (`app`, `bootstrap`, `config`, `database`, `routes`, `tests`) SHALL проходити синтаксичну перевірку на PHP 8.4 і SHALL NOT викликати deprecation-повідомлень під час штатної роботи.

#### Scenario: Синтаксична перевірка
- **WHEN** виконується `php -l` для кожного PHP-файлу проєкту на PHP 8.4
- **THEN** жодного синтаксичного чи deprecation-повідомлення не виводиться

#### Scenario: Штатні сторінки без deprecation
- **WHEN** відкриваються головна сторінка, сторінка входу адміністратора та API-маршрути з `LOG_DEPRECATIONS_CHANNEL` у режимі логування
- **THEN** у `storage/logs/laravel.log` не з'являється записів про deprecated-функціональність PHP

### Requirement: Автоматичні тести проходять на PHP 8.4
Набір тестів проєкту SHALL виконуватися на PHP 8.4 і завершуватися успішно.

#### Scenario: Запуск тестів
- **WHEN** виконується `php artisan test` у `workspace-84`
- **THEN** усі тести проходять

### Requirement: Функціональність застосунку не змінюється
Перехід на PHP 8.4 SHALL NOT змінювати поведінку маршрутів, автентифікації адмінки, CRUD-розділів і API.

#### Scenario: Список маршрутів збігається
- **WHEN** порівнюється вивід `php artisan route:list` до і після міграції
- **THEN** набір маршрутів ідентичний

#### Scenario: Вхід в адмінку
- **WHEN** користувач відкриває `/admin/login`
- **THEN** форма входу відображається зі статусом 200

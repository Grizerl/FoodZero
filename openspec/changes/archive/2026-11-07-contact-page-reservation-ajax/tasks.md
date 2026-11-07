## 1. Конфіг і служба розкладу

- [x] 1.1 Створити `config/reservations.php` (`slots`, `open_days`, `horizon_days`) і зробити `app.timezone` керованим через `env('APP_TIMEZONE', 'UTC')`; додати `APP_TIMEZONE` у `.env.example`; перевірити: `php artisan tinker --execute="dump(config('reservations'))"` у `workspace-84` друкує очікуваний масив
- [x] 1.2 Створити `App\Services\ReservationSchedule` (`slotsFor`, `isBookable`, `firstOpenDate`, `bounds`) з одним запитом на добу для зайнятих слотів; перевірити: unit/feature-тести — слот зайнятий лише на свою дату, наступного дня вільний, минулі слоти сьогодні `available: false`, субота закрита

## 2. Бекенд: ендпоінти й валідація

- [x] 2.1 Додати `GET /foodzero/reservation/slots` (`reservation.slots`, `throttle:60,1`, `Cache-Control: no-store`) із валідацією дати; перевірити: feature-тести на 200 зі структурою `slots[].time|available`, 422 на сміттєву дату/суботу/минуле/поза вікном
- [x] 2.2 Переробити `ReservationRequest`: поля `reservation_date` + `reservation_slot`, складання `reservation_time`, `Rule::in(slots)`, не в минулому, робочий день, `unique`; повідомлення «This time is already booked. Please choose another one.»; перевірити: feature-тести для кожного сценарію зі `table-reservations` (час поза переліком, минулий слот, закритий день, зайнятий слот)
- [x] 2.3 Оновити `HomeController::reservation`: `201 JSON` при `expectsJson()`, редірект як раніше інакше; перехоплювати `UniqueConstraintViolationException` → `ValidationException` з тим самим повідомленням; додати `throttle:10,1` на `reservation.submit`; перевірити: тест на дубль (друга вставка на той самий слот → 422, у БД один запис) і тест, що non-JSON запит ще редіректить із `success`
- [x] 2.4 Усі нові feature-тести працюють із `DatabaseTransactions` і датами далекого майбутнього; перевірити: `php artisan test` проходить двічі поспіль, кількість рядків `reservations` у dev-БД до і після не змінюється

## 3. Форма на сторінках

- [x] 3.1 Переписати `partials/form.blade.php`: поле `reservation_date` (`min`/`max` з `bounds()`), `<fieldset class="slots">` з radio+label слотів (початковий рендер із `ReservationSchedule`, зайняті `disabled`), місце для помилок `[data-error-for]` і `.form-status[aria-live]`; no-JS режим зберігає `old()` і `session('success')`; перевірити: HTML сторінок `/foodzero`, `/foodzero/contact`, `/foodzero/menu`, `/foodzero/about` відповідає 200 і має `label[for]` для кожного `input`/`select` та `legend` у групі слотів
- [x] 3.2 SCSS слотів (`.slots`, `.slot`, `:checked`, `:disabled`, `focus-visible`, сітка `auto-fill`) та `.form-status` у `resources/scss/index.scss`; `npm run scss:build` на хості; перевірити: збірка без помилок, `public/assets/css/**` оновлено і закомічено, а зайнятий слот візуально сірий (скриншот)
- [x] 3.3 Створити `public/assets/js/reservation.js` (зміна дати → fetch слотів; submit через fetch з `Accept: application/json`; успіх/422/мережева помилка; блокування кнопки; фокус на перше невалідне поле; перезавантаження слотів після успіху) і підключити в `layouts/app` через `@assetv`; перевірити: у headless Chrome — відправка не викликає `load`/навігації (`performance.navigation`/подія `framenavigated`), повідомлення з'являється на місці, слот стає `disabled`, повторне натискання створює один запис
- [x] 3.4 Зміна дати: скидання вибору слоту, повідомлення «Closed on …» для зачинених днів і «No free tables on this day» для повністю зайнятих; перевірити: сценарії з браузерного прогону (субота, день із усіма зайнятими слотами через тестові записи в транзакції/ручне створення й видалення)

## 4. Кнопка «Call us»

- [x] 4.1 У `pages/contact.blade.php` додати `<dialog id="call-dialog">` (роль, підпис, номер, «Copy number», «Call», «Close») і `data-call-dialog` на кнопці; стилі `.call-dialog` у `resources/scss/pages/contact.scss` (+ перекомпіляція); перевірити: без JS кнопка лишається `a[href="tel:+868523460000"]`
- [x] 4.2 Створити `public/assets/js/contact-call.js` (підключається лише на contact через `@section`): десктоп → `showModal()`, touch (`(hover: none) and (pointer: coarse)`) → дефолтний `tel:`; копіювання з фолбеком, Escape/Close/клік поза діалогом, повернення фокуса; перевірити: у headless Chrome клік відкриває діалог, `location` не змінюється, «Copy number» змінює підпис на «Copied», Escape повертає фокус на кнопку

## 5. Верифікація

- [x] 5.1 Запустити `tools/visual-audit` (`node audit.mjs`, `node compare.mjs`) для 7 сторінок × 4 ширини; перевірити: немає горизонтального скролу (375 px — слоти переносяться), жодних нових `h1`/вкладених `<a>`, регресій лейауту поза формою й діалогом
- [x] 5.2 Пройти end-to-end вручну на `http://foodzero.local/foodzero/contact`: забронювати слот → без перезавантаження з'являється повідомлення → слот сірий → інша дата має його вільним → дубль з іншої вкладки дає повідомлення про зайнятий слот; прибрати тестові броні; перевірити: у `reservations` лишаються лише початкові записи
- [x] 5.3 `vendor/bin/pint` на змінених PHP-файлах і `php artisan test` у `workspace-84`; перевірити: Pint без змін, усі тести зелені (результат: Pint чистий; `ReservationTest` 12/12; 2 тести `ExampleTest` падали й до зміни — маршрути `/` та `/admin/login` не збігаються з тестом — і поза обсягом цієї зміни)

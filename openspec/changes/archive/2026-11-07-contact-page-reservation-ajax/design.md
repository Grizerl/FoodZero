## Context

- Форма бронювання — один партіал `resources/views/partials/form.blade.php`, підключений на головній, menu, about і contact. Вона робить звичайний `POST /foodzero/reservation` (`HomeController@reservation`) і повертає `redirect()->back()->with('success', …)`.
- Поля: `guest_name`, `reservation_time` (`datetime-local`), `guest_count` (рядок `"N Person"`). `ReservationRequest` перевіряє `unique:reservations,reservation_time`; таблиця `reservations` має `UNIQUE(reservation_time)` (міграція `2025_03_03_140325`). Тобто «один стіл на дату+час» уже забезпечено БД, а доступність «по даті» — це просто вибірка по `reservation_time`.
- JS публічного сайту — статичні файли в `public/assets/js` (`index-slider.js`, `adaptive-menu.js`), підключені в `layouts/app` через `@assetv`; кожен скрипт толерантний до відсутніх елементів. Стилі — SCSS (`resources/scss/index.scss` містить `.reservation-form`, `.field__*`, `.form-error`, `.form-success`), компіляція `npm run scss:build` на хості.
- Тести ходять у dev-БД `zero`; `RefreshDatabase` заборонено (див. CLAUDE.md).
- Часовий пояс застосунку `UTC` (`config/app.php`), ресторан за текстом — у Culver City, CA.

## Goals / Non-Goals

**Goals:**
- Усе, що вимагають специфікації `table-reservations` і `contact-page-actions`, без нових залежностей і без змін схеми БД.
- Одне джерело правди про слоти (конфіг + одна служба) для форми, ендпоінта доступності та валідації.
- Форма лишається працездатною без JS (деградація до редіректу).

**Non-Goals:**
- Ємність більше одного столу на слот, керування слотами з адмінки, листи/SMS-підтвердження, скасування броні гостем.
- Зміни адмін-панелі та Sanctum-API резервацій.
- Переведення застосунку на часовий пояс ресторана.
- JS-фреймворк, Vite, бібліотеки діалогів/календарів.

## Decisions

**1. Конфіг слотів у `config/reservations.php`.** Ключі: `slots` (масив `H:i`), `open_days` (ISO-номери днів: 0 = неділя … 6 = субота; за замовчуванням `[0,1,2,3,4,5]`), `horizon_days` (30). Значення за замовчуванням виведені зі смуги «Open time» (Sunday–Friday; Brunch 11:00, Lunch 13:00–17:00, Dinner 18:00–20:00; слот = початок, остання година закінчення не бронюється): `11:00, 13:00, 14:00, 15:00, 16:00, 18:00, 19:00`. Змінюються правкою конфіга без коду.
*Альтернатива:* таблиця `time_slots` в БД з адмінкою — зайве, поки немає вимоги редагувати розклад.

**2. Служба `App\Services\ReservationSchedule`.** Методи: `slotsFor(CarbonImmutable $date): array` (слоти з `available`), `isBookable(CarbonImmutable $moment): bool`, `firstOpenDate(): CarbonImmutable`, `bounds()` (мін/макс дати + закриті дні для атрибутів поля). «Зайнято» = існує `Reservation` з `reservation_time` у цей день (один запит `whereBetween` на добу, ключі `H:i`); «минуло» = момент ≤ `now()`. Усі порівняння в `config('app.timezone')`.
*Чому служба:* логіку використовують контролер, FormRequest і Blade (початковий рендер) — інакше вона розповзеться по трьох місцях.

**3. Ендпоінт `GET /foodzero/reservation/slots?date=YYYY-MM-DD` (`reservation.slots`).** Валідується окремо (`date_format:Y-m-d`, `after_or_equal:today`, `before_or_equal:+horizon`, робочий день); відповідь `200 {"date": "...", "slots": [{"time": "11:00", "label": "11:00", "available": true}, …]}`, помилка — `422`. Заголовок `Cache-Control: no-store`, окремий іменований ліміт `reservation-slots` (60/хв на IP). Маршрут оголошується **до** ресурсних/параметричних маршрутів, поруч із `reservation.submit`.
*Альтернатива:* віддавати всі зайняті слоти на 30 днів при завантаженні сторінки — дані застарівають, поки форма відкрита; запит на зміну дати дешевий і завжди актуальний.

**4. Поля форми й складання `reservation_time`.** Форма надсилає `reservation_date` (`Y-m-d`) і `reservation_slot` (`H:i`). `ReservationRequest::prepareForValidation()` зліплює `reservation_time = "{date} {slot}:00"`, а правила: `reservation_slot` — `Rule::in(config slots)`, `reservation_date` — формат/межі/робочий день, `reservation_time` — `unique` + не в минулому (кастомне правило, що викликає `ReservationSchedule::isBookable`). Контролер зберігає `validated()` без зайвих полів (`only guest_name, reservation_time, guest_count`). Модель, адмінка та Sanctum-API не змінюються.
*Альтернатива:* лишити одне поле `reservation_time` і збирати значення на клієнті — тоді сервер не відрізнить «слот поза переліком» від зловмисного вводу, а no-JS-режим не матиме звідки взяти значення.

**5. Гонка двох запитів.** Валідація `unique` — лише дружнє раннє повідомлення; остаточний арбітр — `UNIQUE(reservation_time)`. `HomeController::reservation` ловить `UniqueConstraintViolationException` (Laravel 12) і кидає `ValidationException::withMessages(['reservation_slot' => 'This time is already booked. Please choose another one.'])`, що дає той самий 422 / редірект з помилкою, що й раннє правило. Транзакція не потрібна: вставка однорядкова.
*Альтернатива:* блокування `SELECT … FOR UPDATE` — не гарантує нічого для відсутнього рядка, а індекс уже є.

**6. Контракт POST.** При `expectsJson()` (заголовок `Accept: application/json`): `201 {"message": "Your reservation has been successfully added."}`; помилки валідації — стандартний `422 {"message", "errors": {поле: [..]}}` від FormRequest; сесія вичерпана (`419`) і інші статуси обробляє клієнт. Без `Accept: json` поведінка як зараз — `redirect()->back()->with('success')`. Маршрут отримує іменований ліміт `reservation-submit` (10/хв на IP), щоб форма не була каналом спаму; ліміти іменовані й мають різні ключі навмисно — числовий `throttle:N,M` ділить один лічильник між маршрутами, і перегляд дат з'їдав би бюджет самої броні.

**7. Клієнт — `public/assets/js/reservation.js` (vanilla, `fetch`).** Знаходить `form.reservation-form`; для кожної форми на сторінці (їх може бути лише одна, але код не ламається за відсутності). Потік: зміна дати → `GET slots` → перемальовування групи слотів → `submit` (`preventDefault`) → `fetch(POST, FormData, Accept: json)` → на `201` показати повідомлення в `.form-status[aria-live="polite"]`, `form.reset()`, повторно завантажити слоти; на `422` — розкласти помилки по `[data-error-for]`, зберегти значення, сфокусувати перше невалідне поле; на мережеву помилку/5xx/419 — загальне повідомлення. Кнопка `disabled` + `aria-busy` на час запиту. CSRF — з прихованого `_token` у `FormData`. Скрипт підключається в `layouts/app` після `adaptive-menu.js`.

**8. Слоти як radio-кнопки.** Розмітка: `<fieldset class="slots"><legend>Time</legend>` + для кожного слота `<input type="radio" name="reservation_slot" id="slot-1100" value="11:00">` і `<label class="slot" for="slot-1100">11:00</label>`; зайнятий слот — `disabled`, що дає клавіатурну поведінку, пропуск у Tab-порядку й семантику «недоступно» безкоштовно. Стилі: `.slot` (вільний), `input:checked + .slot` (обраний, колір бренду), `input:disabled + .slot` (сірий фон/текст, `cursor: not-allowed`, перекреслення для не-колірного маркера). Сітка `repeat(auto-fill, minmax(88px, 1fr))` переносить слоти на 375 px.
*Альтернатива:* `<select>` — «сірі» опції не стилізуються кросбраузерно.
Початковий рендер (для no-JS і для повторного показу після помилки) робить Blade через `ReservationSchedule` для `old('reservation_date')` або `firstOpenDate()`; у `value`/`min`/`max` поля дати передаються межі, закриті дні відсікає сервер і JS (повідомлення «Closed on Saturdays»).

**9. «Call us» — `<dialog>` + прогресивне покращення.** У `contact.blade.php` кнопка залишається `<a href="tel:…">` з `data-call-dialog`, поруч — `<dialog id="call-dialog">` із номером, `<button>` «Copy number», `<a class="btn" href="tel:…">Call</a>` і «Close». Скрипт `contact-call.js` (окремий, лише для contact) на клік: якщо `matchMedia('(hover: none) and (pointer: coarse)').matches` — нічого не робить (браузер іде за `tel:`), інакше `preventDefault()` + `dialog.showModal()`. Нативний `<dialog>` дає фокус-пастку, Escape і `::backdrop`; клік по backdrop закриваємо вручну, фокус повертаємо на кнопку-тригер. Копіювання — `navigator.clipboard.writeText` з фолбеком на виділення тексту (`Selection`), підпис «Copied» на ~2 с.
*Альтернатива:* власний popover/модалка на div — довше і гірше з доступністю.

## Risks / Trade-offs

- **Годинні слоти й вихідні — припущення зі смуги «Open time»** → винесено в конфіг; зміна — правка одного файла (див. Open Questions).
- **Часовий пояс**: застосунок у UTC, ресторан у Каліфорнії → «минулий слот» і «сьогодні» рахуються за `app.timezone`; для правильної поведінки на проді потрібно виставити `APP_TIMEZONE`/`app.timezone` ресторана. Зараз `config/app.php` має жорстко `'UTC'` → у завданні робимо `env('APP_TIMEZONE', 'UTC')` і додаємо ключ у `.env.example`.
- **Ручні броні з адмінки на довільний час** (напр. 12:30) не збігаються зі слотом і не блокують його → прийнятно, вони не видно в гостьовій формі; повідомлення в адмін-UI не змінюємо.
- **Гість A і B вибрали один слот одночасно** → B отримує 422 з поясненням, клієнт перезавантажує слоти, і зайнятий слот стає сірим.
- **Без JS** слоти відрізняються лише для початкової дати; після помилки/повернення показується дата з `old()` → прийнятна деградація, повний інтерактив вимагає JS.
- **Кешування**: JSON слотів — `no-store`, щоб проксі/браузер не показували застарілу доступність.
- **Тести в dev-БД**: нові тести використовують `DatabaseTransactions` та вигадані дати далекого майбутнього, щоб не конфліктувати з реальними бронями; жодних `RefreshDatabase`/truncate.

## Open Questions

- Чи збігаються припущені години слотів і робочі дні (нд–пт) з реальними? Відповідь змінює лише `config/reservations.php`.
- Чи потрібне обмеження «не менше ніж за N годин до слота» (зараз — просто «не в минулому»)? Додається одним параметром у конфіг.

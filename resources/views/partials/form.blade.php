@php
    $schedule = app(App\Services\ReservationSchedule::class);
    $chosenDate = $schedule->parseDate(old('reservation_date'));
    $chosenDate = $chosenDate && $schedule->isBookableDate($chosenDate) ? $chosenDate : $schedule->firstOpenDate();
    $slots = $schedule->slotsFor($chosenDate);
    $hasFreeSlot = collect($slots)->contains('available', true);
@endphp
<section class="section-reservation" id="reservation">
    <div class="container">
        <div class="reservation-card">
            <div class="section-head section-head--center">
                <p class="eyebrow">Reservations</p>
                <h2 class="section-heading">Make a Reservation</h2>
                <p class="section-lead">Tell us when you would like to visit and we will keep a table for you.</p>
            </div>
            <form action="{{ route('reservation.submit') }}" class="reservation-form" method="post" novalidate
                  data-slots-url="{{ route('reservation.slots') }}"
                  data-closed-days="{{ implode(',', $schedule->closedDays()) }}">
                @csrf
                <div class="field">
                    <label class="field__label" for="guest_name">Name</label>
                    <input id="guest_name" type="text" class="field__input" name="guest_name" value="{{ old('guest_name') }}" placeholder="Reservation name" autocomplete="name" required>
                    <div class="form-error" role="alert" data-error-for="guest_name">@error('guest_name'){{ $message }}@enderror</div>
                </div>
                <div class="field">
                    <label class="field__label" for="reservation_date">Date</label>
                    <input id="reservation_date" type="date" class="field__input" name="reservation_date"
                           value="{{ $chosenDate->format('Y-m-d') }}"
                           min="{{ $schedule->today()->format('Y-m-d') }}" max="{{ $schedule->lastDate()->format('Y-m-d') }}" required>
                    <div class="form-error" role="alert" data-error-for="reservation_date">@error('reservation_date'){{ $message }}@enderror</div>
                </div>
                <div class="field">
                    <label class="field__label" for="guest_count">Guests</label>
                    <select id="guest_count" class="field__input" name="guest_count" required>
                        @foreach ([1, 2, 3, 4, 5] as $count)
                            @php($value = $count.' Person')
                            <option value="{{ $value }}" {{ old('guest_count') == $value ? 'selected' : '' }}>{{ $count }} {{ $count === 1 ? 'person' : 'people' }}</option>
                        @endforeach
                    </select>
                    <div class="form-error" role="alert" data-error-for="guest_count">@error('guest_count'){{ $message }}@enderror</div>
                </div>
                <fieldset class="slots" data-slots>
                    <legend class="field__label">Time</legend>
                    <div class="slots__list" data-slots-list>
                        @foreach ($slots as $slot)
                            @php($slotId = 'slot-'.str_replace(':', '', $slot['time']))
                            <input id="{{ $slotId }}" class="slots__input" type="radio" name="reservation_slot" value="{{ $slot['time'] }}"
                                   {{ $slot['available'] ? '' : 'disabled' }} {{ old('reservation_slot') === $slot['time'] && $slot['available'] ? 'checked' : '' }}>
                            <label class="slots__slot" for="{{ $slotId }}">{{ $slot['label'] }}</label>
                        @endforeach
                    </div>
                    <p class="slots__hint" data-slots-hint>{{ $hasFreeSlot ? '' : 'No free tables on this day. Please choose another date.' }}</p>
                    <div class="form-error" role="alert" data-error-for="reservation_slot">@error('reservation_slot'){{ $message }}@enderror</div>
                </fieldset>
                <button type="submit" class="btn btn--primary reservation-form__submit">Book now</button>
                <div class="form-status{{ session('success') ? ' form-success' : '' }}" role="status" aria-live="polite" data-form-status>{{ session('success') }}</div>
            </form>
        </div>
    </div>
</section>

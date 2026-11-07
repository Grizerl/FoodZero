<section class="section-reservation" id="reservation">
    <div class="container">
        <div class="reservation-card">
            <div class="section-head section-head--center">
                <p class="eyebrow">Reservations</p>
                <h2 class="section-heading">Make a Reservation</h2>
                <p class="section-lead">Tell us when you would like to visit and we will keep a table for you.</p>
            </div>
            <form action="{{ route('reservation.submit') }}" class="reservation-form" method="post">
                @csrf
                <div class="field">
                    <label class="field__label" for="guest_name">Name</label>
                    <input id="guest_name" type="text" class="field__input" name="guest_name" value="{{ old('guest_name') }}" placeholder="Reservation name" autocomplete="name" required>
                    @error('guest_name')
                        <div class="form-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="field__label" for="reservation_time">Date and time</label>
                    <input id="reservation_time" type="datetime-local" class="field__input" name="reservation_time" value="{{ old('reservation_time') }}" required>
                    @error('reservation_time')
                        <div class="form-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="field">
                    <label class="field__label" for="guest_count">Guests</label>
                    <select id="guest_count" class="field__input" name="guest_count" required>
                        @foreach ([1, 2, 3, 4, 5] as $count)
                            @php($value = $count.' Person')
                            <option value="{{ $value }}" {{ old('guest_count') == $value ? 'selected' : '' }}>{{ $count }} {{ $count === 1 ? 'person' : 'people' }}</option>
                        @endforeach
                    </select>
                    @error('guest_count')
                        <div class="form-error" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn--primary reservation-form__submit">Book now</button>
            </form>
            @if (session('success'))
                <div class="form-success" role="status">{{ session('success') }}</div>
            @endif
        </div>
    </div>
</section>

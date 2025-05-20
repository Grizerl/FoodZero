<section>
    <div class="section-reservation">
        <div>
            <div class="container">
                <div class="reservation-container d-flex">
                    <h1 class="headline-2">Make a Reservation</h1>
                    <p class="lead">Get in touch with restaurant</p>
                    <div class="form-group">
                    <form action="{{ route('reservation.submit') }}" class="reservation-form d-grid" method="post">
                    @csrf
                    <div class="sc-FVfd d-flex">
                        <div class="sc-InpPole">
                            <input type="text" class="date-pole"  name="guest_name" placeholder="Reservation name" required>
                            @error('guest_name')
                                <div style="text-align: center; color: red; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       <div class="sc-InpPole">
                         <input type="datetime-local" class="time-pole"  name="reservation_time" required>
                            @error('reservation_time')
                                <div style="text-align: center; color: red; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
                            @enderror
                       </div>
                       <div class="sc-InpPole">
                        <select class="quantity"  name="guest_count" required>
                            <option value="1 Person" {{ old('guest_count') == '1 Person' ? 'selected' : '' }}>1 Person</option>
                            <option value="2 Person" {{ old('guest_count') == '2 Person' ? 'selected' : '' }}>2 Person</option>
                            <option value="3 Person" {{ old('guest_count') == '3 Person' ? 'selected' : '' }}>3 Person</option>
                            <option value="4 Person" {{ old('guest_count') == '4 Person' ? 'selected' : '' }}>4 Person</option>
                            <option value="5 Person" {{ old('guest_count') == '5 Person' ? 'selected' : '' }}>5 Person</option>
                        </select>
                            @error('guest_count')
                                <div style="text-align: center; color: red; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
                            @enderror
                       </div>
                    </div>
                    <div style="text-align: center;" class="w-100">
                        <button style="border:none;" type="submit">
                            <a class="btn-reservation">Book Now</a>
                        </button>
                    </div>
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <h4 style="text-align: center; color: green; margin-top: 20px;" ><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                            </div>
                        @endif
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
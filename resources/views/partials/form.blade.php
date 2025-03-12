<section>
    <div class="section-reservation">
        <div>
            <div class="container">
                <div class="reservation-container d-flex">
                    <h1 class="headline-2">Make a Reservation</h1>
                    <p class="lead">Get in touch with restaurant</p>
                    <div class="form-group">
                    <form action="{{ route('reservation.store') }}" class="reservation-form d-grid" method="post">
                    @csrf
                    <div class="sc-FVfd d-flex">
                        <div>
                            <input type="text" class="date-pole @error('name') is-invalid @enderror" name="name" placeholder="Reservation name">
                            @error('name')
                                <div style="text-align: center; color: red; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                       <div>
                         <input type="datetime-local" class="time-pole @error('data_time') is-invalid @enderror" name="data_time">
                            @error('data_time')
                                <div style="text-align: center; color: red; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
                            @enderror
                       </div>
                       <div>
                        <select class="quantity @error('quantity') is-invalid @enderror" name="quantity">
                            <option value="1 Person" {{ old('quantity') == '1 Person' ? 'selected' : '' }}>1 Person</option>
                            <option value="2 Person" {{ old('quantity') == '2 Person' ? 'selected' : '' }}>2 Person</option>
                            <option value="3 Person" {{ old('quantity') == '3 Person' ? 'selected' : '' }}>3 Person</option>
                            <option value="4 Person" {{ old('quantity') == '4 Person' ? 'selected' : '' }}>4 Person</option>
                            <option value="5 Person" {{ old('quantity') == '5 Person' ? 'selected' : '' }}>5 Person</option>
                        </select>
                            @error('quantity')
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
@extends('layouts.app')
@section('title', 'FoodZero — Healthy Restaurant & Fresh Seasonal Food')
@section('meta.description', 'Healthy eating is an important part of lifestyle. Discover the FoodZero menu, read our food blog and book a table online.')

@section('content')
<section class="hero">
    <div class="container hero__grid">
        <div class="hero__copy">
            <p class="eyebrow eyebrow--light">Seasonal kitchen · Culver City</p>
            <h1 class="hero__title">Healthy eating is an important part of lifestyle</h1>
            <p class="hero__text">
                Fresh ingredients from local growers, cooked simply and served with care.
                Come for a quick lunch or a long dinner: our menu changes with the seasons.
            </p>
            <div class="hero__actions">
                <a class="btn btn--light" href="{{ route('contact.page') }}">Book a table</a>
                <a class="btn btn--ghost" href="{{ route('menu.page') }}">View the menu <span class="btn__arrow" aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
        <div class="hero__visual">
            <figure class="hero__plate">
                <img src="/assets/images/ImageMeat.png" alt="Cooked meat on a white ceramic plate" width="594" height="699">
            </figure>
            <div class="hero__spices">
                <figure><img src="/assets/images/seasonings/spices1.png" alt="A bowl of ground spices with star anise" loading="lazy"></figure>
                <figure><img src="/assets/images/seasonings/spices2.png" alt="A bowl of whole peppercorns" loading="lazy"></figure>
                <figure><img src="/assets/images/seasonings/spices3.png" alt="A bowl of dried seeds" loading="lazy"></figure>
            </div>
        </div>
    </div>
</section>

<section class="diet">
    <div class="container diet__grid">
        <div class="diet__main">
            <figure class="diet__photo diet__photo--wide">
                <img src="/assets/images/Image (13).png" width="700" height="370" loading="lazy" alt="Clam and vegetable soup">
            </figure>
            <h2 class="diet__title">Start to plan your diet today</h2>
            <p class="diet__text">Our chefs balance every plate with fresh vegetables, lean proteins and whole grains, so eating well never feels like a compromise.</p>
        </div>
        <div class="diet__side">
            <p class="diet__text diet__text--side">We season with sea salt, freshly ground pepper and herbs from our own garden instead of heavy sauces, so you taste the ingredients first.</p>
            <figure class="diet__photo diet__photo--tall">
                <img src="/assets/images/Image (14).png" width="420" height="550" loading="lazy" alt="Salt and pepper grinders">
            </figure>
        </div>
    </div>
</section>

<section class="section section--light">
    <div class="container">
        <div class="menu-content">
            <div class="section-head">
                <p class="eyebrow">From our kitchen</p>
                <h2 class="section-heading">Our Menu</h2>
                <p class="section-lead">Our signature dishes, made daily from fresh seasonal ingredients.</p>
            </div>
            <img class="menu-content__leaf" src="/assets/images/Image (15).png" alt="" loading="lazy">
        </div>
        @if ($dishes->isNotEmpty())
            <div class="menu-list">
                @foreach ($dishes as $dish)
                    @include('partials.dish-card', ['dish' => $dish])
                @endforeach
            </div>
            <div class="section-cta">
                <a class="btn btn--outline" href="{{ route('menu.page') }}">See the full menu <span class="btn__arrow" aria-hidden="true">&rarr;</span></a>
            </div>
        @endif
    </div>
</section>

<section class="cook">
    <div class="container cook__grid">
        <div class="cook__images">
            <img class="cook__leaf" src="/assets/images/excellent cook/Leaf.png" loading="lazy" alt="">
            <img class="cook__plate" src="/assets/images/excellent cook/brown-wooden-round-plate-with-food 1.png" loading="lazy" alt="A wooden plate with a salmon dish">
            <img class="cook__chef" src="/assets/images/excellent cook/man-in-black-crew-neck-t-shirt-eating 1.png" loading="lazy" alt="Our chef plating a dish">
        </div>
        <div class="cook__copy">
            <p class="eyebrow">Our chefs</p>
            <h2 class="section-heading">Excellent cook</h2>
            <p class="cook__text">Our chefs have spent years learning from farmers, fishermen and bakers. They choose every ingredient by hand and cook it the way it deserves: simply, patiently and with plenty of flavor.</p>
            <img class="cook__leaf-line" src="/assets/images/excellent cook/Leaf (1).png" loading="lazy" alt="">
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="values">
            <div class="value">
                <div class="vector-container"><img class="img-fish" src="/assets/images/layers/Vector.png" loading="lazy" alt=""></div>
                <h2 class="value__title">Premium Quality</h2>
                <p class="value__text">We source fish and meat from trusted suppliers and check every delivery before it reaches the kitchen.</p>
            </div>
            <div class="value">
                <div class="vector-container"><img class="img-carot" src="/assets/images/layers/Vector (1).png" loading="lazy" alt=""></div>
                <h2 class="value__title">Seasonal Vegetables</h2>
                <p class="value__text">Our vegetables come from nearby farms and arrive within a day of harvest, so they taste of what they are.</p>
            </div>
            <div class="value">
                <div class="vector-container"><img class="img-lemon" src="/assets/images/layers/Vector (2).png" loading="lazy" alt=""></div>
                <h2 class="value__title">Fresh Fruit</h2>
                <p class="value__text">Ripe fruit goes into our desserts, drinks and dressings: never from a can and never out of season.</p>
            </div>
        </div>
    </div>
</section>

@if ($posts->isNotEmpty())
<section class="section section--light">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow">From the blog</p>
            <h2 class="section-heading">Recipes &amp; stories</h2>
        </div>
        <div class="post-grid post-grid--duo">
            @foreach ($posts as $post)
                @include('partials.post-card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.form')

<section class="section section--light">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow">Eat well</p>
            <h2 class="section-heading">Calories Energy Balance</h2>
            <p class="section-lead">Every dish lists its calories, so you can plan a light starter, a hearty main or a warm soup around your day.</p>
        </div>
        <div class="tiles">
            <a class="tile" href="{{ route('fullMenu.page') }}">
                <img src="/assets/images/calories-img/Image.png" alt="" loading="lazy">
                <span class="tile__title">Starters</span>
                <span class="tile__arrow" aria-hidden="true">&rarr;</span>
            </a>
            <a class="tile" href="{{ route('fullMenu.page') }}">
                <img src="/assets/images/calories-img/Image (1).png" alt="" loading="lazy">
                <span class="tile__title">Mains</span>
                <span class="tile__arrow" aria-hidden="true">&rarr;</span>
            </a>
            <a class="tile" href="{{ route('fullMenu.page') }}">
                <img src="/assets/images/calories-img/Image (2).png" alt="" loading="lazy">
                <span class="tile__title">Soups</span>
                <span class="tile__arrow" aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow">Kind words</p>
            <h2 class="section-heading">What our guests say</h2>
        </div>
        @php
            $reviews = [
                ['Dianne Russell', 'Food blogger', 'Dianne Russell.png', 'The most honest food in the neighborhood. The seasonal tasting plate changed my mind about vegetables, and the staff remembered my name on the second visit.'],
                ['John Doe', 'Food blogger', 'John Doe.png', 'I come for the herb-roasted chicken and stay for the dessert. Everything tastes fresh and nothing on the plate is there just for show.'],
                ['Julie Christie', 'Food blogger', 'Julie Christie.png', 'A calm room, generous portions and a menu that really changes with the seasons. We booked a table online and it took less than a minute.'],
            ];
        @endphp
        <div class="slideshow-container" aria-roledescription="carousel" aria-label="Guest reviews">
            @foreach ($reviews as $i => [$name, $role, $photo, $quote])
                <figure class="mySlides fade">
                    <blockquote class="slide-text">
                        <p>&ldquo;{{ $quote }}&rdquo;</p>
                    </blockquote>
                    <figcaption class="slide-people">
                        <div class="slide-person">
                            <img width="80" height="80" src="/assets/images/slider-people/{{ $photo }}" alt="{{ $name }}" loading="lazy">
                            <div>
                                <h3>{{ $name }}</h3>
                                <span>{{ $role }}</span>
                            </div>
                        </div>
                        <div class="number-slide">
                            <button type="button" class="slider-btn prev" onclick="plusSlides(-1)" aria-label="Previous review">&#10094;</button>
                            <span aria-live="polite">{{ $i + 1 }}/{{ count($reviews) }}</span>
                            <button type="button" class="slider-btn next" onclick="plusSlides(1)" aria-label="Next review">&#10095;</button>
                        </div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endsection

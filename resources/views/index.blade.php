@extends('layouts.app')
@section('title', 'FoodZero — Healthy Restaurant & Fresh Seasonal Food')
@section('meta.description', 'Healthy eating is an important part of lifestyle. Discover the FoodZero menu, read our food blog and book a table online.')

@section('content')
    <section>
        <div>
            <div class="container">
                <div class="banner-content">
                    <div>
                        <h1 class="banner-slogan sc-scgFG">
                            Healthy Eating 
                            is important
                            part of lifestyle
                        </h1>
                        <p class="banner-text">
                            Lorem ipsum dolor sit amet, 
                            consectetur adipiscing elit. Neque congue arcu
                        </p>
                        <h4 class="banner-scroll">
                            Scroll
                        </h4>
                    </div>
                    <div class="section-img">
                        <figure style="text-align: center;">
                            <img class="banner-img" src="/assets/images/ImageMeat.png" alt="Cooked meat on white ceramic plate" loading="lazy">
                        </figure>
                        <div class="block-seasonings">
                            <figure>
                                <img  src="/assets/images/seasonings/spices1.png" alt="Spices" loading="lazy">
                            </figure>
                            <figure>
                                <img  src="/assets/images/seasonings/spices2.png" alt="Spices" loading="lazy">
                            </figure>
                            <figure>
                                <img src="/assets/images/seasonings/spices3.png" alt="Spices" loading="lazy">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
    <div class="section-diet-today">
        <div class="container">
            <div class="sc-Adfg text-white">
                <div style="padding-right: 8px;">
                    <figure style="--width: 700; --height: 370">
                        <img class="img-cover" width="700" height="370" src="/assets/images/Image (13).png" loading="lazy" alt="Clam and vegetable soup">
                    </figure>
                    <div>
                        <h2 class="section-title">Start to plan your diet today</h2>
                        <p class="section-text max-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Neque congue arcu</p>
                    </div>
                </div>
                <div>
                    <p class="section-text max-width">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Neque congue arcu</p>
                    <figure style="--width: 420; --height: 550">
                        <img class="img-cover" width="420" height="550" src="/assets/images/Image (14).png" loading="lazy" alt="Two black pepper and salt">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-menu">
        <div>
            <div class="container">
                <div class="menu-content">   
                    <div>
                        <h2 class="headline-1">Our Menu</h2>
                        <p class="menu-text text-light max-width">Our signature dishes, made daily from fresh seasonal ingredients.</p>
                    </div>
                    <img  src="/assets/images/Image (15).png" alt="Annie-spratt" loading="lazy">
                </div>
                @if ($dishes->isNotEmpty())
                    <div class="menu-list d-grid">
                        @foreach ($dishes as $dish)
                            @include('partials.dish-card', ['dish' => $dish])
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-excellent-cook">
        <div>
            <div class="container">
                <div class="cook-container d-flex">
                    <div class="images-block">
                        <img class="leaf" src="/assets/images/excellent cook/Leaf.png" loading="lazy" alt="Leaf">
                        <div>
                            <figure>
                                <img class="img-wooden" src="/assets/images/excellent cook/brown-wooden-round-plate-with-food 1.png" loading="lazy" alt="Brown wooden">
                            </figure>
                            <figure>
                                <img class="img-chef" src="/assets/images/excellent cook/man-in-black-crew-neck-t-shirt-eating 1.png" loading="lazy" alt="Chef">
                            </figure>
                        </div>
                    </div>
                    <div>
                        <h2 class="section-cook-title">Excellent cook</h2>
                        <p class="section-cook-text max-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Purus lorem id penatibus imperdiet. Turpis egestas ultricies purus auctor tincidunt lacus nunc. </p>
                        <figure class="text-right">
                            <img class="leaf-section" src="/assets/images/excellent cook/Leaf (1).png" loading="lazy" alt="Lead">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-layers">
        <div>
            <div class="container">
                <div class="layers-container d-grid">
                    <div class="layers-fish">
                        <div class="vector-container">
                            <figure>
                                <img class="img-fish" src="/assets/images/layers/Vector.png" loading="lazy" alt="Vector">
                            </figure>
                        </div>
                        <div class="w-100 text-centre">
                            <h2 class="layers-title">Premium Quality</h2>
                            <p class="layers-text max-width">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Neque congue arcu</p>
                        </div>
                    </div>
                    <div class="layers-carot">
                        <div class="vector-container">
                            <figure>
                                <img class="img-carot" src="/assets/images/layers/Vector (1).png" loading="lazy" alt="Vector">
                            </figure>
                        </div>
                        <div class="w-100 text-centre">
                            <h2 class="layers-title">Seasonal Vegetables</h2>
                            <p class="layers-text max-width">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Neque congue arcu</p>
                        </div>
                    </div>
                    <div class="layers-lemon">
                        <div class="vector-container">
                            <figure>
                                <img class="img-lemon" src="/assets/images/layers/Vector (2).png" loading="lazy" alt="Vector">
                            </figure>
                        </div>
                        <div class="w-100 text-centre">
                            <h2 class="layers-title">Fresh Fruit</h2>
                            <p class="layers-text max-width">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Neque congue arcu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if ($posts->isNotEmpty())
<section>
    <div class="section-fashion">
        <div class="container">
            <div class="post-grid post-grid--duo">
                @foreach ($posts as $post)
                    @include('partials.post-card', ['post' => $post])
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
@include('partials.form')
<section>
    <div class="section-balance">
        <div>
            <div class="container">
                <div class="energy-content d-flex">
                    <div>
                        <h2 class="energy-title max-text ">Calories Energy Balance</h2>
                        <p class="energy-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                    <div class="calories-images d-grid">
                        <figure class="img-container">
                            <h4 class="img-title">Starters</h4>
                            <img src="/assets/images/calories-img/Image.png" alt="Starters" loading="lazy">
                            <a class="arrow sc-sfFGg" href="{{ route('fullMenu.page') }}">&rarr;</a>
                        </figure>
                        <figure class="img-container">
                            <h4 class="img-title">Mains</h4>
                            <img src="/assets/images/calories-img/Image (1).png" alt="Mains" loading="lazy">
                            <a class="arrow sc-sfFGg" href="{{ route('fullMenu.page') }}">&rarr;</a>
                        </figure>
                        <figure class="img-container">
                            <h4 class="img-title">Soups</h4>
                            <img src="/assets/images/calories-img/Image (2).png" alt="Soups" loading="lazy">
                            <a class="arrow sc-sfFGg" href="{{ route('fullMenu.page') }}">&rarr;</a>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-swiper">
        <div>
            <div class="container">
                <div class="slideshow-container">
                    <div class="mySlides fade" style="position: relative;">
                        <div class="slide-text d-flex">
                            <p>“ Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Purus lorem id penatibus imperdiet. Turpis egestas ultricies 
                                purus  Lorem ipsum dolor sit amet.
                            </p>
                            <img style="user-select: none; position:absolute; right: 0;" src="/assets/images/slider-people/”.png" alt="”" loading="lazy">
                        </div>
                        <div class="slide-people d-flex">
                            <div class="d-flex" style="align-items: center;">
                                <img width="200" height="200" src="/assets/images/slider-people/Dianne Russell.png" alt="Dianne Russell" loading="lazy">
                                <div>
                                    <h3>Dianne Russell</h3>
                                    <span>Blogger</span>
                                </div>
                            </div>
                            <div class="number-slide">
                                <a onclick="plusSlides(-1)" class="prev">&#10094</a>
                                    1/3
                                <a onclick="plusSlides(1)" class="next">&#10095</a>
                            </div>
                        </div>
                    </div>
                    <div class="mySlides fade" style="position: relative;">
                        <div class="slide-text d-flex">
                            <p>“ Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Purus lorem id penatibus imperdiet. Turpis egestas ultricies 
                                purus  Lorem ipsum dolor sit amet.
                            </p>
                            <img style="user-select: none; position:absolute; right: 0;" src="/assets/images/slider-people/”.png" alt="”" loading="lazy">
                        </div>
                        <div class="slide-people d-flex">
                            <div class="d-flex" style="align-items: center;">
                                <img width="200" height="200" src="/assets/images/slider-people/John Doe.png" alt="John Doe" loading="lazy">
                                <div>
                                    <h3>John Doe</h3>
                                    <span>Blogger</span>
                                </div>
                            </div>
                            <div class="number-slide">
                                <a onclick="plusSlides(-1)" class="prev">&#10094</a>
                                    2/3
                                <a onclick="plusSlides(1)" class="next">&#10095</a>
                            </div>
                        </div>
                    </div>
                    <div class="mySlides fade" style="position: relative;">
                        <div class="slide-text d-flex">
                            <p>“ Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Purus lorem id penatibus imperdiet. Turpis egestas ultricies 
                                purus  Lorem ipsum dolor sit amet.
                            </p>
                            <img style="user-select: none; position:absolute; right: 0;" src="/assets/images/slider-people/”.png" alt="”" loading="lazy">
                        </div>
                        <div class="slide-people d-flex">
                            <div class="d-flex" style="align-items: center;">
                                <img width="200" height="200" src="/assets/images/slider-people/Julie Christie.png" alt="Julie Christie" loading="lazy">
                                <div>
                                    <h3>Julie Christie</h3>
                                    <span>Blogger</span>
                                </div>
                            </div>
                            <div class="number-slide">
                                <a onclick="plusSlides(-1)" class="prev">&#10094</a>
                                    3/3
                                <a onclick="plusSlides(1)" class="next">&#10095</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
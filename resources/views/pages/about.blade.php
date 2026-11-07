@extends('layouts.app')
@section('title', 'About Us — FoodZero')
@section('meta.description', 'Meet the FoodZero team and learn how our chefs prepare every dish, from slicing to baking.')

@section('link.css')
    <link rel="stylesheet" href="@assetv('assets/css/pages/about.css')">
@endsection

@section('content')
@include('partials.page-banner', ['variant' => 'about', 'title' => 'Who We Are', 'lead' => 'The most important thing for us is to give you a comfortable dining experience'])

<section class="section section--light">
    <div class="container story">
        <div class="story__copy">
            <p class="eyebrow">Since day one</p>
            <h2 class="section-heading">Our Story</h2>
            <p class="story__lead">FoodZero started as a small family kitchen with one idea: good food should be fresh, honest and simple.</p>
            <p class="story__text">Today we still cook that way. We work with nearby farms, bake our own bread every morning and change the menu with the seasons, so every visit tastes a little different.</p>
        </div>
        <figure class="story__photo">
            <img src="/assets/images/about/Chef.png" alt="Our chef at work in the kitchen" loading="lazy">
            <img class="tomato" src="/assets/images/about/Tomato.png" alt="" aria-hidden="true" loading="lazy">
        </figure>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow">The people</p>
            <h2 class="section-heading">Meet the team</h2>
        </div>
        <div class="team">
            <article class="member">
                <figure class="member__photo">
                    <img width="470" height="570" src="/assets/images/about/team members/Brain.png" alt="Carson Hugn, Restaurant Manager" loading="lazy">
                </figure>
                <div class="member__body">
                    <h3 class="member__name">Carson Hugn</h3>
                    <p class="member__role">Restaurant Manager</p>
                    <p class="member__quote">Good service starts before the first guest arrives. My job is to make every table feel looked after, from the first greeting to the last coffee.</p>
                </div>
            </article>
            <article class="member">
                <figure class="member__photo">
                    <img width="470" height="570" src="/assets/images/about/team members/John.png" alt="John Miller, Head Chef" loading="lazy">
                </figure>
                <div class="member__body">
                    <h3 class="member__name">John Miller</h3>
                    <p class="member__role">Head Chef</p>
                    <p class="member__quote">I build every plate around what is best at the market that week. A short menu, cooked well, is all a good restaurant needs.</p>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="video">
    <div class="container video__inner">
        <h2 class="video__title">It looks delicious</h2>
        <p class="video__text">Take a look behind the scenes and see how a dish travels from the market to your table.</p>
        <button type="button" class="video__play" aria-label="Play video">
            <img width="85" height="85" src="/assets/images/about/8666551_play_circle_icon.svg" alt="" loading="lazy">
        </button>
    </div>
</section>

<section class="section section--light process">
    <img class="rosemary" src="/assets/images/about/stage/rosemary.png" alt="" loading="lazy">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow">How we cook</p>
            <h2 class="section-heading">Sophisticated Process</h2>
        </div>
        <ol class="stages">
            <li class="stage">
                <figure class="stage__photo">
                    <img src="/assets/images/about/stage/Slice.png" alt="Meat being sliced" loading="lazy">
                </figure>
                <div class="stage__body">
                    <p class="stage__number">01</p>
                    <h3 class="stage__title">Slice</h3>
                    <p class="stage__text">Every ingredient is cut by hand, just before cooking. Thin slices cook evenly and keep their texture, so each bite is tender and full of flavor.</p>
                </div>
            </li>
            <li class="stage">
                <figure class="stage__photo">
                    <img src="/assets/images/about/stage/Pickled.png" alt="Pickled meat with herbs" loading="lazy">
                </figure>
                <div class="stage__body">
                    <p class="stage__number">02</p>
                    <h3 class="stage__title">Pickled</h3>
                    <p class="stage__text">We marinate meat and vegetables in herbs, citrus and a little vinegar. A few hours is enough to deepen the flavor and keep the dish light.</p>
                </div>
            </li>
            <li class="stage">
                <figure class="stage__photo">
                    <img src="/assets/images/about/stage/Bake.png" alt="Meat baked until golden" loading="lazy">
                </figure>
                <div class="stage__body">
                    <p class="stage__number">03</p>
                    <h3 class="stage__title">Bake</h3>
                    <p class="stage__text">Slow baking in a hot oven finishes the dish: golden outside, juicy inside, with no heavy sauces or extra oil.</p>
                </div>
            </li>
        </ol>
    </div>
    <img class="rosemary rosemary--second" src="/assets/images/about/stage/rosemary (1).png" alt="" loading="lazy">
</section>
@include('partials.form')
@endsection

@extends('layouts.app')
@section('title', 'Full Menu — FoodZero')
@section('meta.description', 'Browse the complete FoodZero menu by category: brunch, lunch and dinner dishes with prices.')

@section('link.css')
<link rel="stylesheet" href="/assets/css/pages/full-menu.css">
@endsection

@section('content')
<section>
    <div class="section_explore_menu">
        <div class="banner_section">
            <div class="background-image d-flex sc-DdgA">
                <div>
                    <div class="banner_text">
                        <h1 class="banner_title">Explore the Menu</h1>
                        <p class="banner_lead">Daily Fresh Ingredients, Just for You</p>
                    </div>
                    <div>
                        <div class="aside_baner_text d-flex">
                            <div class="sc-Fcsg d-flex">
                                <span class="open_time">Open Time</span>
                                <span class="open_day">Sunday - Friday</span>
                            </div>
                            <div class="sc-FDdg d-flex">
                                <div class="info_container d-flex">
                                    <span class="Brunch">Brunch</span>
                                    <span class="time">11:00–12:00</span>
                                </div>
                                <div class="info_container d-flex">
                                    <span class="Lunch">Lunch</span>
                                    <span class="time">13:00–17:00</span>
                                </div>
                                <div class="info_container d-flex">
                                    <span class="Dinner">Dinner</span>
                                    <span class="time">18:00–20:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section_all_menu">
        <div class="container">
            @if ($categories->isEmpty())
                @include('partials.empty-state', ['title' => 'The menu is not available yet', 'text' => 'We are preparing our dishes. Please check back soon.'])
            @else
                <nav class="menu-nav" aria-label="Menu categories">
                    @foreach ($categories as $category)
                        <a class="menu-nav__link" href="#category-{{ $category->id }}">{{ $category->name }}</a>
                    @endforeach
                </nav>
                <div class="menu-categories">
                    @foreach ($categories as $category)
                        @include('partials.menu-category', [
                            'id' => 'category-'.$category->id,
                            'title' => $category->name,
                            'dishes' => $category->menu,
                            'image' => $category->images_category,
                            'imageAlt' => $category->name,
                            'reverse' => $loop->even,
                            'decor' => $loop->odd
                                ? ['class' => 'blueberry', 'src' => '/assets/images/menu/starters/Blueberry.png']
                                : ['class' => 'avocado', 'src' => '/assets/images/menu/Pastries&Drinks/Avocado.png'],
                        ])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
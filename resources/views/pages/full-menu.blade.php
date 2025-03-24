@extends('layouts.app')

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
        <div>
            <div class="container">
                <div class="menu-content d-flex">
                <div class="section_menu_items">
                    <ul class="menu_navbar d-flex">
                        @foreach($categories as $category)
                        <li class="menu_items">
                            <a class="menu_links" href="#category-{{ $category->id }}">{{ $category->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="category_items_content">
                    @foreach($categories as $category)
                        <div class="category_items_content" id="category-{{ $category->id }}">
                            <div class="menu-header">
                                <h1 class="menu-title">{{ $category->name }}</h1>
                                    <p class="menu-lead">This is a section of your menu. Give your section a brief description</p>
                                    <div class="blueberry">
                                        <img src="/assets/images/menu/starters/Blueberry.png" alt="Blueberry">
                                    </div>
                            </div>
                            <div class="menu-bottom d-grid">
                            <figure>
                                <img class="dish-images" src="{{ $category->images_category }}" alt="{{ $category->name }}">
                            </figure>
                            <div class="menu-right">
                                @foreach($category->menu as $product)
                                    <span class="product-price d-block">
                                        {{$product->price}}$
                                    </span>
                                <div class="dish-container">
                                    <h2 class="dish-name max-wid-title">{{ $product->name }}</h2>
                                    <p class="dish-description">{{ $product->description }}</p>
                                </div>
                                @endforeach
                            </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
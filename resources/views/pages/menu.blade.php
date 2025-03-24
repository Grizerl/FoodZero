@extends('layouts.app')

@section('link.css')
<link rel="stylesheet" href="/assets/css/pages/menu.css">
@endsection

@section('content')
<section>
    <div class="section-menu-banner h-100">
        <div class="background-img d-flex sc-fzfGF">
            <div class="background-content">
                <h1 class="banner-slogan max-widt">View Our New Menu</h1>
                <p class="banner-lead">The freshest ingredients for you every day</p>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section_all_menu">
        <div>
            <div class="container">
                <div class="menu-content d-flex">
                    <div class="starters-content">
                        <div class="menu-header">
                            <h1 class="menu-title">Starters</h1>
                            <p class="menu-lead">This is a section of your menu. Give your section a brief description</p>
                            <div class="blueberry">
                                <img src="/assets/images/menu/starters/Blueberry.png" alt="Blueberry">
                            </div>
                        </div>
                        <div class="menu-bottom d-grid">
                            <figure>
                                <img class="dish-images" src="/assets/images/menu/starters/cheese.png" alt="Cheese">
                            </figure>
                            <div class="menu-right">
                                @foreach ($starters as $starter)
                                    <span class="product-price d-block">
                                        {{ $starter->price }}$
                                    </span>
                                    <div class="dish-container">
                                        <h2 class="dish-name max-wid-title">{{ $starter->name}}</h2>
                                        <p class="dish-description">{{ $starter->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mains-content">
                        <div class="menu-header">
                            <h1 class="menu-title">Mains</h1>
                            <p class="menu-lead">This is a section of your menu. Give your section a brief description</p>
                        </div>
                        <div class="menu-bottom d-grid">
                            <div class="menu-right">
                                @foreach ($mains as $main)
                                    <span class="product-price d-block">
                                        {{ $main->price }}$
                                    </span>
                                    <div class="dish-container">
                                        <h2 class="dish-name max-wid-title">{{ $main->name}}</h2>
                                        <p class="dish-description">{{ $main->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <figure style="text-align: center;">
                                <img class="dish-images" src="/assets/images/menu/Main/Beef.png" alt="Beef">
                            </figure>
                        </div>
                    </div>
                    <div class="pastries-content">
                        <div class="menu-header">
                            <h1 class="menu-title">Pastries & Drinks</h1>
                            <p class="menu-lead">This is a section of your menu. Give your section a brief description</p>
                            <div class="avocado">
                                <img src="/assets/images/menu/Pastries&Drinks/Avocado.png" alt="Avocado">
                            </div>
                        </div>
                        <div class="menu-bottom d-grid">
                            <figure>
                                <img class="dish-images" src="/assets/images/menu/Pastries&Drinks/cups.png" alt="Four cups">
                            </figure>
                            <div class="menu-right">
                                @foreach ($pastries_And_Drinks as $dessertsAndDrinks)
                                    <span class="product-price d-block">
                                        {{ $dessertsAndDrinks->price }}$
                                    </span>
                                    <div class="dish-container">
                                        <h2 class="dish-name max-wid-title">{{ $dessertsAndDrinks->name}}</h2>
                                        <p class="dish-description">{{ $dessertsAndDrinks->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button class="btm__menu">
                        <a href="{{ route('fullMenu.page') }}">Complete <span>menu </span></a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials.form')
@endsection
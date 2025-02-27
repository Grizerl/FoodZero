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
    <div class="section-menu">
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
                                <span class="product-price d-block">
                                    20$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name max-wid-title">Grilled Okra and Tomatoes</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                                <span class="product-price d-block">
                                    18$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name">Cucumber Salad</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                                <span class="product-price d-block">
                                    12$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name">Basil Pancakes</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
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
                                <span class="product-price d-block">
                                    20$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name max-wid-title">Deep Sea Snow White Cod Fillet</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                                <span class="product-price d-block">
                                    22$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name max-wid-title">Steak With Rosemary Butter</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                                <span class="product-price d-block">
                                    20$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name max-wid-title">Steaks with Grilled Kimchi</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
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
                                <span class="product-price d-block">
                                    158$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name max-wid-title">Wine Pairing</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                                <span class="product-price d-block">
                                    168$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name">Natural Wine Pairing</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                                <span class="product-price d-block">
                                    90$
                                </span>
                                <div class="dish-container">
                                    <h2 class="dish-name">Whisky Flyer</h2>
                                    <p class="dish-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials.form')
@endsection
@extends('layouts.app')
@section('title', 'Menu — FoodZero')
@section('meta.description', 'Starters, mains, pastries and drinks made daily from fresh seasonal ingredients at FoodZero.')

@section('link.css')
<link rel="stylesheet" href="@assetv('assets/css/pages/menu.css')">
@endsection

@section('content')
@include('partials.page-banner', ['variant' => 'menu', 'title' => 'View Our New Menu', 'lead' => 'The freshest ingredients for you every day'])
<section>
    <div class="section_all_menu">
        <div class="container">
            <nav class="menu-nav" aria-label="Menu categories">
                <a class="menu-nav__link" href="#starters">Starters</a>
                <a class="menu-nav__link" href="#mains">Mains</a>
                <a class="menu-nav__link" href="#pastries">Pastries &amp; Drinks</a>
            </nav>
            <div class="menu-categories">
                @include('partials.menu-category', [
                    'id' => 'starters',
                    'title' => 'Starters',
                    'lead' => 'Light bites to begin with: crisp, fresh and made to share.',
                    'dishes' => $starters,
                    'image' => '/assets/images/menu/starters/cheese.png',
                    'imageAlt' => 'Caprese salad on a patterned plate',
                    'decor' => ['class' => 'blueberry', 'src' => '/assets/images/menu/starters/Blueberry.png'],
                ])
                @include('partials.menu-category', [
                    'id' => 'mains',
                    'title' => 'Mains',
                    'lead' => 'Hearty plates built around seasonal produce and slow-cooked classics.',
                    'dishes' => $mains,
                    'image' => '/assets/images/menu/Main/Beef.png',
                    'imageAlt' => 'Grilled steak with rosemary',
                    'reverse' => true,
                ])
                @include('partials.menu-category', [
                    'id' => 'pastries',
                    'title' => 'Pastries & Drinks',
                    'lead' => 'Something sweet, a proper coffee or a glass of natural wine.',
                    'dishes' => $pastries_And_Drinks,
                    'image' => '/assets/images/menu/Pastries&Drinks/cups.png',
                    'imageAlt' => 'Four cups of fruit drinks with ice',
                    'decor' => ['class' => 'avocado', 'src' => '/assets/images/menu/Pastries&Drinks/Avocado.png'],
                ])
            </div>
            <div class="section-cta">
                <a class="btn btn--primary" href="{{ route('fullMenu.page') }}">Complete menu <span class="btn__arrow" aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </div>
</section>
@include('partials.form')
@endsection

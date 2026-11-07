@extends('layouts.app')
@section('title', 'Full Menu — FoodZero')
@section('meta.description', 'Browse the complete FoodZero menu by category: brunch, lunch and dinner dishes with prices.')

@section('link.css')
<link rel="stylesheet" href="@assetv('assets/css/pages/full-menu.css')">
@endsection

@section('content')
@include('partials.page-banner', ['variant' => 'full-menu', 'title' => 'Explore the Menu', 'lead' => 'Daily fresh ingredients, just for you', 'hours' => true])
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
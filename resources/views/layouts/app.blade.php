<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta.description', 'FoodZero — restaurant with fresh seasonal ingredients, a daily menu, a food blog and online table reservations.')">
    <link rel="stylesheet" href="@assetv('assets/css/index.css')">
    <link rel="stylesheet" href="@assetv('assets/css/app.css')">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Brand.png') }}">
    @yield('link.css')
    <title>@yield('title', 'FoodZero-Restaurant and Food')</title>
</head>
<body>
@php
    // Shared by the header, the full-screen menu and the footer.
    $menuLinks = [
        ['home.page', 'Home', ['home.page']],
        ['menu.page', 'Menu', ['menu.page', 'fullMenu.page']],
        ['blog.page', 'Blog', ['blog.page', 'post.details.page']],
        ['about.page', 'About', ['about.page']],
        ['contact.page', 'Contact', ['contact.page']],
    ];
@endphp
<div class="app">
    <div>
        @include('partials.header')
        <main>
            @yield('content')
        </main>
    </div>
    @include('partials.footer')
</div>
<script src="@assetv('assets/js/index-slider.js')"></script>
<script src="@assetv('assets/js/adaptive-menu.js')"></script>
</body>
</html>

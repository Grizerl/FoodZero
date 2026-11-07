<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta.description', 'FoodZero — restaurant with fresh seasonal ingredients, a daily menu, a food blog and online table reservations.')">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Brand.png') }}">
    @yield('link.css')
    <title>@yield('title', 'FoodZero-Restaurant and Food')</title>
</head>
<body>
<div class="app">
    <div>
        <div class="container">
            @include('partials.header')
        </div>
        @yield('content')
    </div>
    @include('partials.footer')
</div>
<script src="{{ asset('assets/js/index-slider.js') }}"></script>
<script src="{{ asset('assets/js/adaptive-menu.js') }}"></script>
</body>
</html>

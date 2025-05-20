<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../../../assets/css/app.css">
    <link rel="website icon" type="png" href="../../../assets/images/Brand.png">
    @yield('link.css')
    <title>FoodZero-Restaurant and Food</title>
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
<script src="../assets/js/index-slider.js"></script>
<script src="../../../assets/js/adaptive-menu.js"></script>
</body>
</html>
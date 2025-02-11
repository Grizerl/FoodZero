<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link CSS -->
    <link rel="stylesheet" href="./css/index.css">
    <title>FoodZero-Restaurant and Food</title>
</head>
<body>
    <div class="app">
        <div>
            <div class="container">
                <header>
                    <div class="navbar-container">
                        <div class="content-left">
                            <h2 class="navbar-logo">FoodZero</h2>
                            <span class="adaptive-icon">&#9776</span>
                        </div>
                        <div class="content-right">
                            <span class="phone-number"><a href="tel:+86 852 346 000">+86 852 346 000</a></span>
                            <button class="btn-reservations">
                                <a href="#">Reservations</a>
                            </button>
                        </div> 
                    </div>
                </header>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>
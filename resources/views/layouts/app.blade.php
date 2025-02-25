<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link CSS -->
    @yield('link.css')

    <link rel="stylesheet" href="assets/css/index.css">
    
    <link rel="stylesheet" href="../assets/css/app.css">
    
    <link rel="website icon" type="png" href="../../assets/images/Brand.png">
    
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
            <div class="burger-menu">
                <span class="close-btn">&#10006;</span>
                <div class="burger-container d-flex">
                    <div class="container-left">
                        <ul class="left-navbar">
                            <li class="left-item">
                                <a class="left-link" href="{{route('home.page')}}">Home</a>
                            </li>
                            <li class="left-item">
                                <a class="left-link" href="{{route('menu.page')}}">Menu</a>
                            </li>
                            <li class="left-item">
                                <a class="left-link"  href="{{route('blog.page')}}">Blogs</a>
                            </li>
                            <li class="left-item">
                                <a class="left-link" href="{{route('about.page')}}">About</a>
                            </li>
                            <li class="left-item">
                                <a class="left-link" href="{{route('contact.page')}}">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="container-right">
                        <h4 class="right-title">Contact</h4>
                        <ul>
                            <li class="right-item">
                                <a class="right-link" href="tel:+1+86 852 346 000">+1+86 852 346 000</a>
                            </li>
                            <li class="right-item">
                                <a class="right-link" href="mailto:info@foodzero.com">info@foodzero.com</a>
                            </li>
                            <li class="right-item">
                                <a class="right-link" href="https://maps.app.goo.gl/3zqKjMHfo8fH2Cto8">1959 Sepulveda Blvd.</a>
                            </li>
                            <li class="right-item">
                                <a class="right-link" href="https://maps.app.goo.gl/b8h5vpRsZghze8kt5">Culver City, CA, 90230</a>
                            </li>
                            <ul class="sc-DdfF d-flex">
                                <li>
                                    <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_instagram.svg" alt="Media icon Instagram"></a>
                                </li>
                                <li>
                                    <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_twitter.svg" alt="Media icon Twitter"></a>
                                </li>
                                <li>
                                    <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_facebook.svg" alt="Media icon Facebook"></a>
                                </li>
                                <li>
                                    <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_youtube.svg" alt="Media icon Youtub"></a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
    <footer>
        <div class="section-foooter">
            <div>
                <div class="container">
                    <div class="footer-container d-grid">
                        <div class="brand-container d-flex">
                            <h2 class="brand">
                                Food
                                Zero.
                            </h2>
                        </div>
                        <div class="contact-container">
                            <h4 class="footer-section-title">Contact</h4>
                            <ul>
                                <li class="contact-item">
                                    <a class="contact-link" href="tel:+1+86 852 346 000">+1+86 852 346 000</a>
                                </li>
                                <li class="contact-item">
                                    <a class="contact-link" href="mailto:info@foodzero.com">info@foodzero.com</a>
                                </li>
                                <li class="contact-item">
                                    <a class="contact-link" href="https://maps.app.goo.gl/3zqKjMHfo8fH2Cto8">1959 Sepulveda Blvd.</a>
                                </li>
                                <li class="contact-item">
                                    <a class="contact-link" href="https://maps.app.goo.gl/b8h5vpRsZghze8kt5">Culver City, CA, 90230</a>
                                </li>
                            </ul>
                        </div>
                        <div class="recipe-container">
                            <h4 class="footer-section-title">Never Miss a Recipe</h4>
                            <div class="d-flex">
                                <input type="email" class="recipe-email email-text" placeholder="Email Address">
                                <button class="email-button sc-Sub">Subscribe</button>
                            </div>
                            <p class="recipe-text">Join our subscribers and get best recipe delivered each week!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <aside class="aside-footer-section">
            <div>
                <div class="container">
                    <div class="aside-container d-flex">
                        <span>© 2020 Zero Inc. All rights Reserved</span>
                        <div class="media-icon">
                            <ul class="d-flex">
                                <li>
                                    <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_instagram.svg" alt="Media icon Instagram"></a>
                                </li>
                                <li>
                                    <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_twitter.svg" alt="Media icon Twitter"></a>
                                </li>
                                <li>
                                    <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_facebook.svg" alt="Media icon Facebook"></a>
                                </li>
                                <li>
                                    <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_youtube.svg" alt="Media icon Youtub"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </footer>
</div>
<script src="../assets/js/index-slider.js"></script>
<script src="../assets/js/adaptive-menu.js"></script>
</body>
</html>
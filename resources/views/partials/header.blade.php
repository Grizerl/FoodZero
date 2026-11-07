@php
    $menuLinks = [
        ['home.page', 'Home', ['home.page']],
        ['menu.page', 'Menu', ['menu.page', 'fullMenu.page']],
        ['blog.page', 'Blogs', ['blog.page', 'post.details.page']],
        ['about.page', 'About', ['about.page']],
        ['contact.page', 'Contact', ['contact.page']],
    ];
@endphp
    <header>
        <div class="navbar-container">
            <div class="content-left">
                <h2 class="navbar-logo">FoodZero</h2>
                <button type="button" class="adaptive-icon" aria-label="Open menu" aria-expanded="false" aria-controls="burger-menu">
                    <span class="adaptive-icon__bar"></span>
                    <span class="adaptive-icon__bar"></span>
                    <span class="adaptive-icon__bar"></span>
                </button>
            </div>
            <div class="content-right">
                <span class="phone-number"><a href="tel:+868523460000">+86 852 346 000</a></span>
                    <button class="btn-reservations">
                        <a href="{{ route('contact.page') }}">Reservations</a>
                    </button>
            </div>
        </div>
    </header>
    <div class="burger-menu" id="burger-menu" aria-hidden="true">
        <button type="button" class="close-btn" aria-label="Close menu"><span class="close-btn__x" aria-hidden="true"></span></button>
        <div class="burger-container d-flex">
            <nav class="container-left" aria-label="Main">
                <ul class="left-navbar">
                    @foreach ($menuLinks as $i => [$route, $label, $active])
                        <li class="left-item" style="--i: {{ $i }}">
                            <a class="left-link" href="{{ route($route) }}" @if (request()->routeIs($active)) aria-current="page" @endif>
                                <span class="left-link__num" aria-hidden="true">0{{ $i + 1 }}</span>
                                <span class="left-link__text">{{ $label }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="container-right">
                <h3 class="right-title">Contact</h3>
                <ul class="sc-navbar">
                    <li class="right-item">
                        <a class="right-link" href="tel:+868523460000">+86 852 346 000</a>
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
                </ul>
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
                        <a class="media-link" href="#"><img height="25" width="25" src="/assets/images/media-icon/Icon_youtube.svg" alt="Media icon YouTube"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

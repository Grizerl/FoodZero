<header class="site-header">
    <div class="container site-header__inner">
        <div class="site-header__left">
            <a class="site-logo" href="{{ route('home.page') }}" aria-label="FoodZero — home">
                <svg class="site-logo__mark" width="34" height="34" viewBox="0 0 34 34" fill="none" aria-hidden="true" focusable="false">
                    <circle cx="17" cy="17" r="16" stroke="currentColor" stroke-width="2" opacity=".45"/>
                    <path d="M10 24c-.5-8 4.5-13.5 14-14.5.5 9.5-4.5 14.5-14 14.5Z" fill="currentColor"/>
                    <path d="M10 24c3.2-4.6 6.6-7.7 10.6-9.8" stroke="#233000" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
                <span>FoodZero</span>
            </a>
            <button type="button" class="adaptive-icon" aria-label="Open menu" aria-expanded="false" aria-controls="burger-menu">
                <span class="adaptive-icon__bar"></span>
                <span class="adaptive-icon__bar"></span>
                <span class="adaptive-icon__bar"></span>
            </button>
        </div>
        <div class="site-header__right">
            <span class="phone-number"><a href="tel:+868523460000">+86 852 346 000</a></span>
            <a class="btn btn--light btn--sm" href="{{ route('contact.page') }}">Reservations</a>
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

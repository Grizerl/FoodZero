<footer class="site-footer">
    <div class="container">
        <div class="site-footer__grid">
            <div class="site-footer__brand">
                <a class="site-logo" href="{{ route('home.page') }}" aria-label="FoodZero — home">
                    <svg class="site-logo__mark" width="34" height="34" viewBox="0 0 34 34" fill="none" aria-hidden="true" focusable="false">
                        <circle cx="17" cy="17" r="16" stroke="currentColor" stroke-width="2" opacity=".45"/>
                        <path d="M10 24c-.5-8 4.5-13.5 14-14.5.5 9.5-4.5 14.5-14 14.5Z" fill="currentColor"/>
                        <path d="M10 24c3.2-4.6 6.6-7.7 10.6-9.8" stroke="#1a2400" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                    <span>FoodZero</span>
                </a>
                <p class="site-footer__pitch">Fresh seasonal cooking, a menu that changes with the market and a table waiting for you.</p>
            </div>
            <nav class="site-footer__nav" aria-label="Footer">
                <h2 class="footer-section-title">Explore</h2>
                <ul class="site-footer__list">
                    @foreach ($menuLinks as [$route, $label])
                        <li><a class="contact-link" href="{{ route($route) }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </nav>
            <div class="site-footer__contact">
                <h2 class="footer-section-title">Contact</h2>
                <ul class="site-footer__list">
                    <li><a class="contact-link" href="tel:+868523460000">+86 852 346 000</a></li>
                    <li><a class="contact-link" href="mailto:info@foodzero.com">info@foodzero.com</a></li>
                    <li><a class="contact-link" href="https://maps.app.goo.gl/3zqKjMHfo8fH2Cto8">1959 Sepulveda Blvd.</a></li>
                    <li><a class="contact-link" href="https://maps.app.goo.gl/b8h5vpRsZghze8kt5">Culver City, CA, 90230</a></li>
                </ul>
            </div>
            <div class="site-footer__subscribe">
                <h2 class="footer-section-title">Never Miss a Recipe</h2>
                <form id="newsletter" class="newsletter" method="POST" action="{{ route('newsletter.subscribe') }}" novalidate data-newsletter-form>
                    @csrf
                    <label class="sr-only" for="footer-email">Email address</label>
                    <input id="footer-email" name="email" type="email" class="recipe-email" placeholder="Email address" autocomplete="email" required maxlength="254" value="{{ old('email') }}" aria-describedby="newsletter-status">
                    <div class="newsletter__trap" aria-hidden="true">
                        <label for="footer-website">Website</label>
                        <input id="footer-website" name="website" type="text" tabindex="-1" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn--light btn--sm">Subscribe</button>
                </form>
                @php($newsletterError = $errors->newsletter->first('email'))
                <p id="newsletter-status" class="newsletter-status{{ session('newsletter_status') ? ' is-success' : ($newsletterError ? ' is-error' : '') }}" role="status" aria-live="polite" data-newsletter-status>{{ session('newsletter_status') ?? $newsletterError }}</p>
                <p class="recipe-text">Join our subscribers and get the best recipes delivered every week.</p>
            </div>
        </div>
    </div>
    <div class="site-footer__bottom">
        <div class="container">
            <div class="aside-container">
                <span>© {{ date('Y') }} FoodZero. All rights reserved.</span>
                <div class="media-icon">
                    <ul>
                        <li><a class="media-link" href="#" aria-label="Instagram"><img height="22" width="22" src="/assets/images/media-icon/Icon_instagram.svg" alt=""></a></li>
                        <li><a class="media-link" href="#" aria-label="Twitter"><img height="22" width="22" src="/assets/images/media-icon/Icon_twitter.svg" alt=""></a></li>
                        <li><a class="media-link" href="#" aria-label="Facebook"><img height="22" width="22" src="/assets/images/media-icon/Icon_facebook.svg" alt=""></a></li>
                        <li><a class="media-link" href="#" aria-label="YouTube"><img height="22" width="22" src="/assets/images/media-icon/Icon_youtube.svg" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

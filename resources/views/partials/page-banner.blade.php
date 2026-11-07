{{--
    Banner at the top of an inner page.
    Expects: $variant (menu|full-menu|blog|post|about|contact), $title
    Optional: $lead, $hours (show the opening hours)
--}}
<section class="page-banner page-banner--{{ $variant }}">
    <div class="container page-banner__inner">
        <h1 class="page-banner__title">{{ $title }}</h1>
        @isset($lead)
            <p class="page-banner__lead">{{ $lead }}</p>
        @endisset
        @if ($hours ?? false)
            <div class="hours">
                <p class="hours__days"><span>Open time</span> <strong>Sunday – Friday</strong></p>
                <ul class="hours__list">
                    <li><span>Brunch</span> <strong>11:00–12:00</strong></li>
                    <li><span>Lunch</span> <strong>13:00–17:00</strong></li>
                    <li><span>Dinner</span> <strong>18:00–20:00</strong></li>
                </ul>
            </div>
        @endif
    </div>
</section>

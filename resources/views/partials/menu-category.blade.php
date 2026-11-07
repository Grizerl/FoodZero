{{--
    One menu category.
    Expects: $id, $title, $dishes, $image, $imageAlt
    Optional: $lead, $decor (['class' => 'blueberry|avocado', 'src' => url]), $reverse
--}}
<div class="menu-category" id="{{ $id }}">
    <div class="menu-header">
        <h2 class="menu-title">{{ $title }}</h2>
        <p class="menu-lead">{{ $lead ?? 'Fresh, seasonal and prepared to order.' }}</p>
        @isset($decor)
            <div class="{{ $decor['class'] }}">
                <img src="{{ $decor['src'] }}" alt="" loading="lazy">
            </div>
        @endisset
    </div>
    <div class="menu-category__body {{ ($reverse ?? false) ? 'menu-category__body--reverse' : '' }}">
        <figure class="menu-figure">
            <img src="{{ $image }}" alt="{{ $imageAlt }}" loading="lazy">
        </figure>
        <div class="dish-grid">
            @forelse ($dishes as $dish)
                @include('partials.dish-card', ['dish' => $dish])
            @empty
                <p class="menu-empty">Dishes for this category are coming soon.</p>
            @endforelse
        </div>
    </div>
</div>

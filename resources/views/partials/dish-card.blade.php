{{-- A dish on the menu. Expects $dish (App\Models\Menu). --}}
<article class="dish-card">
    <div class="dish-card__top">
        <h3 class="dish-name">{{ $dish->name }}</h3>
        <span class="dish-card__dots" aria-hidden="true"></span>
        <span class="product-price">${{ $dish->price }}</span>
    </div>
    <p class="dish-description">{{ $dish->description }}</p>
</article>

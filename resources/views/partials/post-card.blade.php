{{-- A blog post card. Expects $post (App\Models\Post). --}}
@php($url = route('post.details.page', $post->id))
<article class="post-card">
    <a class="post-card__media" href="{{ $url }}" tabindex="-1" aria-hidden="true">
        <img src="{{ $post->images }}" alt="" width="530" height="400" loading="lazy">
        <span class="post-card__tag">Recipes</span>
    </a>
    <div class="post-card__body">
        <div class="post-card__meta">
            <img class="post-card__avatar" src="{{ $post->clients_img }}" alt="" width="40" height="40" loading="lazy">
            <span class="post-card__author">{{ $post->clients }}</span>
            @if ($post->created_at)
                <time class="post-card__date" datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('M j, Y') }}</time>
            @endif
        </div>
        <h2 class="post-card__title"><a href="{{ $url }}">{{ $post->title }}</a></h2>
        <p class="post-card__excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($post->description), 130, '…', true) }}</p>
        <a class="post-card__more" href="{{ $url }}">Read More <span class="post-card__more-arrow" aria-hidden="true">&rarr;</span></a>
    </div>
</article>

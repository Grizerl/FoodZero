@extends('layouts.app')
@section('title', $post->title.' — FoodZero')
@section('meta.description', \Illuminate\Support\Str::limit(strip_tags($post->description), 155))

@section('link.css')
    <link rel="stylesheet" href="@assetv('assets/css/pages/extra.css')">
@endsection

@section('content')
<section>
    <div class="section_detail_banner">
        <div class="background_img d-flex sc-CbaHFG">
            <div class="banner_container">
                <h1 class="banner_title">{{ $post->title }}</h1>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section_media_pole">
        <div class="sc-Fcdg d-flex al-centre just-centre">
            <div class="container">
                <div class="section_category d-flex al-centre just-centre">
                    <ul class="category_navbar d-flex">
                        <li class="category_items">
                            <a class="category_links" href="{{ route('home.page') }}">Home</a>/
                        </li>
                        <li class="category_items">
                            <a class="category_links" href="{{ route('blog.page') }}">Blog</a>/
                        </li>
                        <li class="category_items">
                            <a class="category_links">{{ $post['title'] }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="text-container d-flex al-centre just-centre">
                        <div class="post-card__meta post-byline">
                            <img class="post-card__avatar" src="{{ $post->clients_img }}" alt="" width="40" height="40">
                            <span class="post-card__author">{{ $post->clients }}</span>
                            @if ($post->created_at)
                                <time class="post-card__date" datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('F j, Y') }}</time>
                            @endif
                        </div>
                        <p class="main-text max-width">{{ strip_tags($post->description) }}</p>
                    </div>
                    <div  class="sc-Ccgg d-flex al-centre just-around">
                        <figure>
                            <img class="adaptive-img" width="550" height="600" class="media_img" loading="lazy" src="{{ $post['images'] }}" alt="{{ $post['title'] }}">
                        </figure>
                        <figure class="sc-FDVC">
                            <img class="adaptive-img" width="550" height="600" class="media_img" loading="lazy" src="/assets/images/blog/detail/Granules.png" alt="Granules">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
<aside>
    <div class="aside_pole">
        <div class="background_foto_in_media_pole d-flex al-centre just-centre">
            <div class="media_container">
                <p class="foto_text max-text">“ Fresh ingredients, honest cooking and a table that always has room for one more.</p>
            </div>
        </div>
    </div>
</aside>
</section>
@if ($related_posts->isNotEmpty())
<section>
    <div class="section-fashion">
        <div class="container">
            <h2 class="post-grid-heading">More from the blog</h2>
            <div class="post-grid post-grid--duo">
                @foreach ($related_posts as $related_post)
                    @include('partials.post-card', ['post' => $related_post])
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
@endsection
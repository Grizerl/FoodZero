@extends('layouts.app')
@section('title', $post->title.' — FoodZero')
@section('meta.description', \Illuminate\Support\Str::limit(strip_tags($post->description), 155))

@section('link.css')
    <link rel="stylesheet" href="@assetv('assets/css/pages/extra.css')">
@endsection

@section('content')
@include('partials.page-banner', ['variant' => 'post', 'title' => $post->title])

<article class="section section--light post-article">
    <div class="container post-article__inner">
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home.page') }}">Home</a></li>
                <li><a href="{{ route('blog.page') }}">Blog</a></li>
                <li aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>
        <div class="post-card__meta post-byline">
            <img class="post-card__avatar" src="{{ $post->clients_img }}" alt="" width="40" height="40">
            <span class="post-card__author">{{ $post->clients }}</span>
            @if ($post->created_at)
                <time class="post-card__date" datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('F j, Y') }}</time>
            @endif
        </div>
        <p class="post-article__text">{{ strip_tags($post->description) }}</p>
        <div class="post-article__images">
            <figure>
                <img width="550" height="600" loading="lazy" src="{{ $post['images'] }}" alt="{{ $post['title'] }}">
            </figure>
            <figure>
                <img width="550" height="600" loading="lazy" src="/assets/images/blog/detail/Granules.png" alt="">
            </figure>
        </div>
    </div>
</article>

<aside class="post-quote">
    <div class="container">
        <blockquote class="post-quote__text">&ldquo;Fresh ingredients, honest cooking and a table that always has room for one more.&rdquo;</blockquote>
    </div>
</aside>

@if ($related_posts->isNotEmpty())
<section class="section section--light">
    <div class="container">
        <div class="section-head section-head--center">
            <p class="eyebrow">Keep reading</p>
            <h2 class="section-heading">More from the blog</h2>
        </div>
        <div class="post-grid post-grid--duo">
            @foreach ($related_posts as $related_post)
                @include('partials.post-card', ['post' => $related_post])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

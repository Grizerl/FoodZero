@extends('layouts.app')
@section('title', 'Blog — FoodZero')
@section('meta.description', 'Recipes, seasonal ingredients and healthy eating stories from the FoodZero kitchen.')

@section('link.css')
    <link rel="stylesheet" href="@assetv('assets/css/pages/blog.css')">
@endsection

@section('content')
<section>
    <div class="section_blog_banner">
        <div class="background_img d-flex sc-CbaHFG">
            <div class="banner_container">
                <h1 class="banner_title">
                    Our Blog
                </h1>
                <p class="banner_lead">
                    Recipes, seasonal ingredients and healthy eating stories from our kitchen
                </p>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-fashion section-blog-list">
        <div class="container">
            @if ($post->isEmpty())
                @include('partials.empty-state', ['title' => 'No posts yet', 'text' => 'Our blog is being prepared. Please check back soon.'])
            @else
                <div class="post-grid">
                    @foreach ($post as $item)
                        @include('partials.post-card', ['post' => $item])
                    @endforeach
                </div>
                @if ($post->hasPages())
                    <nav class="paginate" aria-label="Blog pages">
                        {{ $post->links() }}
                    </nav>
                @endif
            @endif
        </div>
    </div>
</section>
@endsection

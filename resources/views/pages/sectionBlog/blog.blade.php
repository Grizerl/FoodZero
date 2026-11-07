@extends('layouts.app')
@section('title', 'Blog — FoodZero')
@section('meta.description', 'Recipes, seasonal ingredients and healthy eating stories from the FoodZero kitchen.')

@section('link.css')
    <link rel="stylesheet" href="@assetv('assets/css/pages/blog.css')">
@endsection

@section('content')
@include('partials.page-banner', ['variant' => 'blog', 'title' => 'Our Blog', 'lead' => 'Recipes, seasonal ingredients and healthy eating stories from our kitchen'])
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

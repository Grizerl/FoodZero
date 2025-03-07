@extends('layouts.app')

@section('link.css')
    <link rel="stylesheet" href="/assets/css/pages/blog.css">
@endsection

@section('content')
<section>
    <div class="section_blog_banner">
        <div class="background_img d-flex sc-CbaHFG">
            <div class="banner_container">
                <h1 class="banner_title">
                    Blogs - Two Columns
                </h1>
                <p class="banner_lead">
                    It is easy way to create your beatiful blog for daily
                </p>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-fashion">
        <div>
            <div class="container">
                <div class="d-flex sc-FAvf">
                    <div class="fashion-container d-grid">
                        @foreach ($post as $posts)
                            <div class="fashion-content">
                                <div class="fashion-img">
                                    <div class="fashion-label">
                                        <span>Fashion</span>
                                    </div>
                                    <img width="530" height="530" src="{{ $posts->images }}" loading="lazy" class="fashion-foto" alt="{{ $posts->title }}">
                                </div>
                                <div class="fashion-info-content d-flex">
                                    <figure>
                                        <img width="60" height="60" class="avatar" src="{{ $posts->clients_img }}" loading="lazy" alt="Avatar">
                                    </figure>
                                    <ul class="navbar-media-content d-flex">
                                        <li class="media-item">{{ $posts->clients}}</li>
                                        <li class="media-item">October 17,2025</li>
                                        <li class="media-item">3:33 pm</li>
                                        <li class="media-item">2 comments</li>
                                    </ul>
                                </div>    
                                <div class="media-section">
                                    <h1 class="fashion-title max-text">{{ $posts->title }}</h1>
                                    <p class="fashion-p">{{ $posts->description }}</p>
                                    <div class="sc-FAfgd d-flex">
                                        <a class="fashion-btn-arrow" href="{{ route('post.details.page',$posts['id']) }}">Read More 
                                            <a href="{{ route('post.details.page',$posts['id']) }}" class="arrow">&rarr;</a>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="paginate">
                    {{ $post->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
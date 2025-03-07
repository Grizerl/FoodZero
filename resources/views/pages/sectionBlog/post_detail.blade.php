@extends('layouts.app')

@section('link.css')
    <link rel="stylesheet" href="/assets/css/pages/extra.css">
@endsection

@section('content')
<section>
    <div class="section_detail_banner">
        <div class="background_img d-flex sc-CbaHFG">
            <div class="banner_container">
                <h1 class="banner_title">
                Three Ideas for Cooking Goat Meat at Home
                </h1>
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
                        <p class="main-text max-width">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Et in sed in pellentesque ornare nunc nisl. 
                            Augue habitant accumsan, ut parturient orci ac etiam congue mi. Elementum pellentesque non hendrerit 
                            et pharetra tellus leo tempus tellus. 
                        </p>
                    </div>
                    <div  class="d-flex al-centre just-around">
                        <figure>
                            <img width="550" height="600" class="media_img" loading="lazy" src="{{ $post['images'] }}" alt="{{ $post['title'] }}">
                        </figure>
                        <figure>
                            <img width="550" height="600" class="media_img" loading="lazy" src="/assets/images/blog/detail/Granules.png" alt="Granules">
                        </figure>
                    </div>
                    <div class="text-container d-flex al-centre just-centre">
                        <p class="aside-text max-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Et in sed in pellentesque ornare nunc nisl. Augue habitant 
                            accumsan, ut parturient orci ac etiam congue mi. Elementum pellentesque non hendrerit et pharetra tellus leo tempus tellus. 
                            Consectetur scelerisque facilisis nunc nunc. Sapien morbi dignissim id tortor vel volutpat facilisi. Cras lectus faucibus sed donec.
                            Est pulvinar adipiscing eget at nunc amet bibendum enim vulputate. Eu orci nec consequat amet. Id cursus purus et fringilla molestie 
                            a nulla turpis. Lobortis dui rutrum sed sit. Mattis quis scelerisque consectetur orci dui est sem nulla.Tortor ullamcorper neque. 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<aside>
    <div class="aside_pole">
        <div class="background_foto_in_media_pole d-flex al-centre just-centre">
            <div class="media_container">
                <p class="foto_text max-text">
                    “ Lorem ipsum dolor sit amet, consectetur adipiscing elit. Purus lorem id penatibus imperdiet. 
                    Turpis egestas ultricies purus auctor tincidunt lacus nunc. 
                </p>
            </div>
        </div>
    </div>
</aside>
</section>
<section>
    <div class="section-fashion">
        <div>
            <div class="container">
                <div class="d-flex sc-FAvf">
                    <div class="fashion-container d-grid">
                         @foreach ($related_posts as $related_post)
                            <div class="fashion-content"> 
                                <div class="fashion-img">
                                    <div class="fashion-label">
                                        <span>Fashion</span>
                                    </div>
                                    <img width="530" height="530" src="{{ $related_post->images }}" loading="lazy" class="fashion-foto" alt="{{ $related_post->title }}">
                                </div>
                                <div class="fashion-info-content d-flex">
                                    <figure>
                                        <img width="60" height="60" class="avatar" src="{{ $related_post->clients_img }}" loading="lazy" alt="Avatar">
                                    </figure>
                                    <ul class="navbar-media-content d-flex">
                                        <li class="media-item">{{ $related_post->clients}}</li>
                                        <li class="media-item">October 17,2025</li>
                                        <li class="media-item">3:33 pm</li>
                                        <li class="media-item">2 comments</li>
                                    </ul>
                                </div>    
                                <div class="media-section">
                                    <h1 class="fashion-title max_text">{{ $related_post->title }}</h1>
                                    <p class="fashion-p">{{ $related_post->description }}</p>
                                    <div class="sc-FAfgd d-flex">
                                        <a class="fashion-btn-arrow" href="{{ route('post.details.page',$related_post['id']) }}">Read More 
                                            <a href="{{ route('post.details.page',$related_post['id']) }}" class="arrow">&rarr;</a>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@extends('layouts.app')

@section('link.css')
    <link rel="stylesheet" href="/assets/css/pages/about.css">
@endsection

@section('content')
<section>
    <div class="section_about_banner">
        <div class="background-img d-flex sc_FDFf">
            <div class="background-content">
                <h1 class="background-title">
                    Who We Are
                </h1>
                <p class="background-text max-text">
                    The most important thing for us is to give you the comfortable dining 
                    experience
                </p>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section_about">
        <div>
            <div class="container">
                <div class="about-content d-flex">
                    <div class="our_story">
                        <h1 class="story_title">
                            Our Story
                        </h1>
                        <p class="story_lead max-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            Purus lorem id penatibus imperdiet. Turpis egestas ultricies purus 
                            auctor tincidunt lacus nunc. 
                        </p>
                    </div>
                        <img class="tomato" src="/assets/images/about/Tomato.png" alt="Tomato" loading="lazy">
                    <figure class="text-end">
                        <img class="img-chef"  src="/assets/images/about/Chef.png" alt="Chef" loading="lazy">
                    </figure>
                </div>
                <aside>
                    <div class="aside-content"> 
                        <div>
                            <div class="top_container">
                                <div class="member_content d-flex">
                                    <div class="text-centre">
                                        <h1 class="role">Restuarant Manager</h1>
                                        <span class="name">Carson Hugn</span>
                                        <figure>
                                            <img class="member-img" width="470" height="570" src="/assets/images/about/team members/Brain.png" alt="Brain" loading="lazy">
                                        </figure>
                                    </div>
                                    <p class="slogan">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing 
                                        elit. Et in sed in pellentesque ornare nunc nisl. 
                                    </p>
                                </div>
                            </div>
                            <div class="bottom_container">
                                <div class="member_content d-flex">
                                    <p class="slogan sc-FvGAS">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                        Et in sed in pellentesque ornare nunc nisl. 
                                        Augue habitant accumsan, ut parturient orci ac etiam 
                                        congue mi. 
                                    </p>
                                    <div class="text-centre">
                                        <h1 class="role">Restuarant Manager</h1>
                                        <span class="name">Carson Hugn</span>
                                        <figure>
                                            <img class="member-img" width="470" height="570" src="/assets/images/about/team members/John.png" alt="John" loading="lazy">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section_video">
        <div>
            <div class="background-foto d-flex sc-FhaFD">
                <div class="video_content">
                    <h1 class="video_name">It looks delicious</h1>
                    <p class="video_description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                    <button onclick="" class="video_play_btn">
                        <img width="85" height="85" src="/assets/images/about/8666551_play_circle_icon.svg" alt="Bnt play" loading="lazy">
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section_process">
        <div>
            <img class="rosemary" src="/assets/images/about/stage/rosemary.png" alt="Rosemary" loading="lazy">
            <div class="container">
                <div class="process_container">
                    <div class="headline_content">
                        <h1 class="headline">Sophisticated Process</h1>
                    </div>
                    <div class="stage d-flex">
                        <figure>
                            <img class="slice_stage" src="/assets/images/about/stage/Slice.png" alt="Slice meat" loading="lazy">
                        </figure>
                        <div class="text-centre">
                            <h1 class="stage_number">01.Slice</h1>
                            <p class="stage_description max-text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Purus lorem id penatibus imperdiet. 
                                Turpis egestas ultricies purus auctor tincidunt lacus nunc. 
                                Convallis pellentesque quis fringilla sagittis. 
                                Egestas in risus sit nunc nunc, arcu donec nam etiam. 
                            </p>
                        </div>
                    </div>
                    <div class="stage d-flex">
                        <div class="text-centre">
                            <h1 class="stage_number">02.Pickled</h1>
                            <p class="stage_description max-text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Purus lorem id penatibus imperdiet.
                            </p>
                        </div>
                        <figure>
                            <img class="slice_stage" src="/assets/images/about/stage/Bake.png" alt="Bake meat" loading="lazy">
                        </figure>
                    </div>
                    <div class="stage d-flex">
                        <figure>
                            <img class="slice_stage" src="/assets/images/about/stage/Pickled.png" alt="Pickled meat" loading="lazy">
                        </figure>
                        <div class="text-centre">
                            <h1 class="stage_number">03.Bake</h1>
                            <p class="stage_description max-text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Purus lorem id penatibus imperdiet. 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <img class="rosemary_second" src="/assets/images/about/stage/rosemary (1).png" alt="Rosemary" loading="lazy">
        </div>
    </div>
</section>
@include('partials.form')
@endsection
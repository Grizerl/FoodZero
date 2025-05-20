@extends('layouts.app')

@section('link.css')
<link rel="stylesheet" href="/assets/css/pages/contact.css">
@endsection

@section('content')
<section>
    <div class="section_contact">
        <div class="banner_section">
            <div class="background-image d-flex sc-DdgA">
                <div>
                    <div class="banner_text">
                        <h1 class="banner_title">Get in Touch</h1>
                        <p class="banner_lead">The freshest ingredients for you every day</p>
                    </div>
                    <div>
                        <div class="aside_baner_text d-flex">
                            <div class="sc-Fcsg d-flex">
                                <span class="open_time">Open Time</span>
                                <span class="open_day">Sunday - Friday</span>
                            </div>
                            <div class="sc-FDdg d-flex">
                                <div class="info_container d-flex">
                                    <span class="Brunch">Brunch</span>
                                    <span class="time">11:00–12:00</span>
                                </div>
                                <div class="info_container d-flex">
                                    <span class="Lunch">Lunch</span>
                                    <span class="time">13:00–17:00</span>
                                </div>
                                <div class="info_container d-flex">
                                    <span class="Dinner">Dinner</span>
                                    <span class="time">18:00–20:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="sc-Ffdjh">
        <div>
            <div class="contact">
                <div class="top_container d-flex">
                    <figure class="sc-DSVdv">
                        <img class="fruit_img" src="/assets/images/contact/Yellow_fruit.png" alt="Yellow_fruit" loading="lazy">
                    </figure>
                    <img class="orange" src="/assets/images/contact/Orange.png" alt="Orange" loading="lazy">
                        <div class="text_container">
                            <p class="img_public_text">We can be contacted via 
                                email <a class="get_in_touch">info@foodzero.com</a> 
                                or telephone on <a class="get_in_touch">+86 852 346 000</a> 
                            </p>
                        </div>
                </div>
                <div class="bottom_container d-flex">
                    <div class="text_container">
                        <p class="img_text">
                            We are located in 1959 Sepulveda Blvd. 
                            Culver City, CA, 90230</a> 
                        </p>
                        <button class="btn_map"><a href="https://maps.app.goo.gl/PjPLxPcNTivPaTp9A" class="map_text">View in maps</a></button>
                    </div>
                    <figure class="sc-VDFcd">
                        <img class="fruit_img" src="/assets/images/contact/House.png" alt="House" loading="lazy">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials.form')
@endsection
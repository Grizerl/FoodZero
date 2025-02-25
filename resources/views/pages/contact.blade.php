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
                    <figure style="text-align: left;">
                        <img class="fruit_img" src="/assets/images/contact/Yellow_fruit.png" alt="Yellow_fruit">
                    </figure>
                    <img class="orange" src="/assets/images/contact/Orange.png" alt="Orange">
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
                        <button class="btn_map"><a href="" class="map_text">View in maps</a></button>
                    </div>
                    <figure style="text-align: right;">
                        <img class="fruit_img" src="/assets/images/contact/House.png" alt="House">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-reservation">
        <div>
            <div class="container">
                <div class="reservation-container d-flex">
                    <img class="mint" src="/assets/images/contact/Mint.png" alt="Mint">
                    <h1 class="headline-2">Make a Reservation</h1>
                    <p class="lead">Get in touch with restaurant</p>
                    <div class="form-group">
                        <form action="#" class="reservation-form d-grid" method="post">
                            <div>
                                <input type="date" class="date-pole" name="date" value="2025-12-16">
                                <input type="datetime" class="time-pole" name="time" placeholder="6:00 pm">
                                <select class="quantity" name="quantity">
                                    <option value="1 Person">1 Person</option>
                                    <option value="2 Person">2 Person</option>
                                    <option value="3 Person">3 Person</option>
                                    <option value="4 Person">4 Person</option>
                                    <option value="5 Person">5 Person</option>`
                                </select>
                            </div>
                            <div style="text-align: center;" class="w-100">
                                <a class="btn-reservation" href="#">Book Now</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
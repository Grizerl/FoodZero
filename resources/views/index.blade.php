@extends('layouts.app')

@section('content')
    <section>
        <div>
            <div class="container">
                <div class="banner-content">
                    <div>
                        <h1 class="banner-slogan sc-scgFG">
                            Healthy Eating 
                            is important
                            part of lifestyle
                        </h1>
                        <p class="banner-text">
                            Lorem ipsum dolor sit amet, 
                            consectetur adipiscing<br> elit. Neque congue arcu
                        </p>
                        <h4 class="banner-scroll">
                            Scroll
                        </h4>
                    </div>
                    <div class="section-img">
                        <figure>
                            <img class="banner-img" src="/assets/images/ImageMeat.png" alt="Cooked meat on white ceramic plate">
                        </figure>
                        <div class="block-seasonings">
                            <figure>
                                <img  src="/assets/images/seasonings/spices1.png" alt="Spices">
                            </figure>
                            <figure>
                                <img  src="/assets/images/seasonings/spices2.png" alt="Spices">
                            </figure>
                            <figure>
                                <img src="/assets/images/seasonings/spices3.png" alt="Spices">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
    <div class="section-diet-today">
        <div class="container">
            <div class="sc-Adfg text-white">
                <div>
                    <figure style="--width: 700; --height: 370">
                        <img class="img-cover" width="700" height="370" src="/assets/images/Image (13).png" loading="lazy" alt="Clam and vegetable soup">
                    </figure>
                    <div>
                        <h2 class="section-title">Start to plan your diet today</h2>
                        <p class="section-text max-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Neque congue arcu</p>
                    </div>
                </div>
                <div>
                    <p class="section-text max-width">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Neque congue arcu</p>
                    <figure style="--width: 420; --height: 550">
                        <img class="img-cover" width="420" height="550" src="/assets/images/Image (14).png" loading="lazy" alt="Two black pepper and salt">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-menu">
        <div>
            <div class="container">
                <div class="menu-content">   
                    <div>
                        <h1 class="headline-1">Our Menu</h1>
                        <p class="menu-text text-light max-width">This is a section of your menu. Give your section a brief description</p>
                    </div>
                    <img  src="/assets/images/Image (15).png" alt="Annie-spratt">
                </div>
                <div>
                    <div class="menu-list d-grid">
                        <div class="menu-item">
                            <div class="price-container text-right">
                                <span class="currency">$</span class="price"><span>20</span>      
                            </div>
                            <div class="card-content">
                                <h2 class="card-title max-text">Deep Sea Snow White Cod Fillet</h2>
                                <p class="card-lead text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="price-container text-right">
                                <span class="currency">$</span class="price"><span>22</span>      
                            </div>
                            <div class="card-content">
                                <h2 class="card-title max-text">Steak With Rosemary Butter</h2>
                                <p class="card-lead text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="price-container text-right">
                                <span class="currency">$</span class="price"><span>18</span>      
                            </div>
                            <div class="card-content">
                                <h2 class="card-title max-text">Cucumber Salad</h2>
                                <p class="card-lead text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                        <div class="menu-item">
                            <div class="price-container text-right">
                                <span class="currency">$</span class="price"><span>90</span>      
                            </div>
                            <div class="card-content">
                                <h2 class="card-title max-text">Natural Wine Pairing</h2>
                                <p class="card-lead text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="section-excellent-cook">
        <div>
            <div class="container">
                <div class="cook-container d-flex">
                    <div class="images-block">
                        <img class="leaf" src="/assets/images/excellent cook/Leaf.png" loading="lazy" alt="Leaf">
                        <div>
                            <figure>
                                <img class="img-wooden" src="/assets/images/excellent cook/brown-wooden-round-plate-with-food 1.png" loading="lazy" alt="Brown wooden">
                            </figure>
                            <figure>
                                <img class="img-chef" src="/assets/images/excellent cook/man-in-black-crew-neck-t-shirt-eating 1.png" loading="lazy" alt="Chef">
                            </figure>
                        </div>
                    </div>
                    <div>
                        <h1 class="section-cook-title">Excellent cook</h1>
                        <p class="section-cook-text max-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Purus lorem id penatibus imperdiet. Turpis egestas ultricies purus auctor tincidunt lacus nunc. </p>
                        <figure class="text-right">
                            <img class="leaf-section" src="/assets/images/excellent cook/Leaf (1).png" loading="lazy" alt="Lead">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
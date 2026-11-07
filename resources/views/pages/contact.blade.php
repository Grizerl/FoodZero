@extends('layouts.app')
@section('title', 'Contact & Reservations — FoodZero')
@section('meta.description', 'Get in touch with FoodZero by phone or email, find us on the map and reserve your table.')

@section('link.css')
<link rel="stylesheet" href="@assetv('assets/css/pages/contact.css')">
@endsection

@section('content')
@include('partials.page-banner', ['variant' => 'contact', 'title' => 'Get in Touch', 'lead' => 'The freshest ingredients for you every day', 'hours' => true])
<section class="section section--light">
    <div class="container contact">
        <div class="contact__row">
            <figure class="contact__photo">
                <img src="/assets/images/contact/Yellow_fruit.png" alt="Yellow fruit on a plate" loading="lazy">
            </figure>
            <div class="contact__card">
                <p class="eyebrow">Talk to us</p>
                <h2 class="contact__title">Questions or special requests?</h2>
                <p class="contact__text">We can be contacted by email at <a class="get_in_touch" href="mailto:info@foodzero.com">info@foodzero.com</a> or by telephone on <a class="get_in_touch" href="tel:+868523460000">+86 852 346 000</a>.</p>
                <div class="contact__actions">
                    <a class="btn btn--primary" href="tel:+868523460000" data-call-dialog="call-dialog" aria-haspopup="dialog">Call us</a>
                    <a class="btn btn--outline" href="mailto:info@foodzero.com">Send an email</a>
                </div>
            </div>
        </div>
        <div class="contact__row contact__row--reverse">
            <div class="contact__card">
                <p class="eyebrow">Visit us</p>
                <h2 class="contact__title">Find us in Culver City</h2>
                <p class="contact__text">We are located at 1959 Sepulveda Blvd., Culver City, CA, 90230.</p>
                <div class="contact__actions">
                    <a class="btn btn--primary" href="https://maps.app.goo.gl/PjPLxPcNTivPaTp9A" target="_blank" rel="noopener">View in maps</a>
                </div>
            </div>
            <figure class="contact__photo">
                <img src="/assets/images/contact/House.png" alt="The FoodZero building" loading="lazy">
            </figure>
        </div>
    </div>
</section>
<dialog class="call-dialog" id="call-dialog" aria-labelledby="call-dialog-title">
    <button type="button" class="call-dialog__close" data-call-close aria-label="Close">&times;</button>
    <h2 class="call-dialog__title" id="call-dialog-title">Call FoodZero</h2>
    <p class="call-dialog__number" data-call-number>+86 852 346 000</p>
    <p class="call-dialog__note">We answer Sunday – Friday.</p>
    <div class="call-dialog__actions">
        <button type="button" class="btn btn--outline" data-call-copy>Copy number</button>
        <a class="btn btn--primary" href="tel:+868523460000">Call</a>
    </div>
</dialog>
@include('partials.form')
@endsection

@section('script.js')
<script src="@assetv('assets/js/contact-call.js')" defer></script>
@endsection
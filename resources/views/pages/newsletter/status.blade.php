@extends('layouts.app')
@section('title', $title.' — FoodZero')

@section('content')
@include('partials.page-banner', ['variant' => 'contact', 'title' => 'Newsletter', 'lead' => 'Recipes and news from FoodZero'])
<section class="section section--light">
    <div class="container">
        @include('partials.empty-state', ['title' => $title, 'text' => $text])
        <p class="text-center"><a class="btn btn--primary" href="{{ route('home.page') }}">Back to the site</a></p>
    </div>
</section>
@endsection

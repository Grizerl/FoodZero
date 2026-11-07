@extends('layouts.admin')

@section('content')
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0">Welcome back, {{ Auth::user()->name }}</h1>
         </div>
      </div>
   </div>
</div>
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-3 col-6">
            <div class="small-box stat-card">
               <div class="inner">
                  <h3>{{ $count_menu }}</h3>
                  <h4>Menu items</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-utensils"></i>
               </div>
               <a href="{{ route('menu.index') }}" class="small-box-footer">View all <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box stat-card">
               <div class="inner">
                  <h3>{{ $count_user }}</h3>
                  <h4>Registered users</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-users"></i>
               </div>
               <a href="{{ route('members.index') }}" class="small-box-footer">View all <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box stat-card">
               <div class="inner">
                  <h3>{{$count_reservation}}</h3>
                  <h4>Reservations</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-book-bookmark"></i>
               </div>
               <a href="{{ route('reservation.index') }}" class="small-box-footer">View all <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box stat-card">
               <div class="inner">
                  <h3>{{$count_blog}}</h3>
                  <h4>Blog posts</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-newspaper"></i>
               </div>
               <a href="{{ route('post.index') }}" class="small-box-footer">View all <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
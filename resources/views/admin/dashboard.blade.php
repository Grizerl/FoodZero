@extends('layouts.admin')

@section('content')
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0">Greetings, {{Auth::user()->name}}! You're in the Admin Panel</h1>
         </div>
      </div>
   </div>
</div>
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
               <div class="inner">
                  <h3>{{ $count_menu }}</h3>
                  <h4>Navigation Menu</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-newspaper"></i>
               </div>
               <a href="{{ route('menu.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
               <div class="inner">
                  <h3>{{ $count_user }}</h3>
                  <h4>Account Registration</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-list"></i>
               </div>
               <a href="{{ route('members.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box bg-success ">
               <div class="inner">
                  <h3>{{$count_reservation}}</h3>
                  <h4>Appointment</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-tag"></i>
               </div>
               <a href="{{ route('reservation.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
               <div class="inner">
                  <h3>{{$count_blog}}</h3>
                  <h4>Post Repository</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-handshake-angle"></i>
               </div>
               <a href="{{ route('post.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
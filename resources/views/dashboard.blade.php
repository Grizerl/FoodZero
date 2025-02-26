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
                  <h3>23</h3>
                  <h4>Main Menu</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-newspaper"></i>
               </div>
               <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
               <div class="inner">
                  <h3>18</h3>
                  <h4>User Registration</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-list"></i>
               </div>
               <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box bg-success ">
               <div class="inner">
                  <h3>20</h3>
                  <h4>Appointment</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-tag"></i>
               </div>
               <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
               <div class="inner">
                  <h3>23</h3>
                  <h4>Main Menu</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-handshake-angle"></i>
               </div>
               <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
         <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
               <div class="inner">
                  <h3>23</h3>
                  <h4>Main Menu</h4>
               </div>
               <div class="icon">
                  <i class="fa-solid fa-handshake-angle"></i>
               </div>
               <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
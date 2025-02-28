@extends('layouts.admin')

@section('content')
   <div class="pt-3 pl-3">
      <h3>Blog Configuration Page</h3>
         @if(session('success'))
            <div class="alert alert-success" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#10006;</button>
               <h4>
                  <i class="icon fa fa-check"></i>{{session('success')}}
               </h4>
            </div>
         @endif
   </div>
   <div class="card-body pb-0">
<form action="{{ route('post.store') }}" method="post">
         @csrf
         <div class="form-group">
            <label for="Dish Name">Blog Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter the Blog Title">
         </div>
         <div class="form-group">
            <label for="Dish Description">Blog Description</label>
            <input type="text" name="description" class="form-control" placeholder="Enter the Blog Description">
         </div>
         <div class="form-group">
            <label for="Blog Photo">Blog Photo</label>
            <input name="blog_images" type="text" class="form-control" id="blog_image" value="" readonly>
            <a href="" class="popup_selector" data-inputid="blog_image">Choose an image</a>
         </div>
         <div class="form-group">
            <label for="Dish Price">Customer Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter the Customer Name">
         </div>
         <div class="form-group">
            <label for="Customer Photo">Customer Photo</label>
            <input name="customer_photo" type="text" class="form-control" id="customer_image" value="" readonly>
            <a href="" class="popup_selector" data-inputid="customer_image">Select an image</a>
         </div>
   </div>
   <div class="card-footer">
      <button type="submit" class="btn btn-primary">Create Post</button>
   </div>
</form>
@endsection
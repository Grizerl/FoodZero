@extends('layouts.admin')

@section('content')
   <div class="pt-3 pl-3">
      <h3>Blog Creation Page</h3>
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
            <label for="Blog Title">Blog Title</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter the Blog Title">
            @error('title')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Blog Description">Blog Description</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter the Blog Description">
            @error('description')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Blog Photo">Blog Photo</label>
            <input name="blog_images" type="text" class="form-control @error('blog_images') is-invalid @enderror" id="blog_image" value="" readonly>
            @error('blog_images')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
            <a href="" class="popup_selector" data-inputid="blog_image">Choose an image</a>
         </div>
         <div class="form-group">
            <label for="Customer Name">Customer Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter the Customer Name">
            @error('name')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Customer Photo">Customer Photo</label>
            <input name="customer_photo" type="text" class="form-control @error('customer_photo') is-invalid @enderror" id="customer_image" value="" readonly>
            @error('customer_photo')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
            <a href="" class="popup_selector" data-inputid="customer_image">Select an image</a>
         </div>
   </div>
   <div class="card-footer">
      <button type="submit" class="btn btn-primary">Create New Post</button>
   </div>
   </form>
@endsection
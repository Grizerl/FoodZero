@extends('layouts.admin')

@section('content')
   <div class="pt-3 pl-3">
      <h3>Category Creation Page</h3>
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
      <form action="{{ route('category.update',$categories['id']) }}" method="post">
         @csrf
         @method('PUT')
         <div class="form-group">
            <label for="Category Title">Category Title</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$categories->name) }}" placeholder="Enter the Category Title">
            @error('title')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Category Photo">Category Photo</label>
            <input name="category_img" type="text" class="form-control @error('category_img') is-invalid @enderror" id="blog_image" value="{{ old('category_img',$categories->images_category) }}" readonly>
            @error('category_img')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
            <a href="" class="popup_selector" data-inputid="blog_image">Choose an image</a>
         </div>
   </div>
   <div class="card-footer">
      <button type="submit" class="btn btn-primary">Create New Category</button>
   </div>
   </form>
@endsection
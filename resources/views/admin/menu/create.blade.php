@extends('layouts.admin')

@section('content')
   <div class="pt-3 pl-3">
      <h3>Menu Customization Page</h3>
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
      <form action="{{ route('menu.store') }}" method="post">
         @csrf
         <div class="form-group">
            <label for="Dish Name">Dish Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter the Dish Name">
            @error('name')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Dish Description">Dish Description</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter the Dish Description">
            @error('description')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Dish Price">Dish Price</label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter the Dish Price">
            @error('price')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group mt-3">
            <label>Select a category</label>
               <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                  @foreach ($categories as $category)
                     <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                  @endforeach
               </select>
            @error('category_id')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Dish Photo">Dish Photo</label>
            <input name="images" type="text" class="form-control @error('images') is-invalid @enderror" id="feature_image" value="" readonly>
            @error('images')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
            <a href="" class="popup_selector" data-inputid="feature_image">Choose an image</a>
         </div>
   </div>
   <div class="card-footer"><button type="submit" class="btn btn-primary">Add a Dish to the Menu</button></div>
      </form>
@endsection
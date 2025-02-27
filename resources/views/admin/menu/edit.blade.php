@extends('layouts.admin')

@section('content')
   <div class="pt-3 pl-3">
      <h3>Product Modification Page</h3>
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
<form action="{{ route('menu.update',$menu['id']) }}" method="post">
         @csrf
         @method('PATCH')
         <div class="form-group">
            <label for="Dish Name">Dish Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter the Dish Name" value="{{ $menu['name'] }}">
         </div>
         <div class="form-group">
            <label for="Dish Description">Dish Description</label>
            <input type="text" name="description" class="form-control" placeholder="Enter the Dish Description" value="{{ $menu['description'] }}">
         </div>
         <div class="form-group">
            <label for="Dish Price">Dish Price</label>
            <input type="text" name="price" class="form-control" placeholder="Enter the Dish Price" value="{{ $menu['price'] }}">
         </div>
         <div class="form-group mt-3">
            <label>Select a category</label>
               <select name="category_id" class="form-control" required>
                  @foreach ($categories as $category)
                  <option value="{{ $category['id'] }}" 
                     {{ old('category_id', $menu->category_id) == $category['id'] ? 'selected' : '' }}>
                     {{ $category['name'] }}
                  </option>
                  @endforeach
               </select>
         </div>
         <div class="form-group">
            <label for="Dish Photo">Dish Photo</label>
            <input name="images" type="text" class="form-control" id="feature_image" value="{{ $menu['images'] }}" readonly>
            <a href="" class="popup_selector" data-inputid="feature_image">Choose an image</a>
         </div>
   </div>
   <div class="card-footer">
      <button type="submit" class="btn btn-primary">Update Menu Item</button>
   </div>
</form>
@endsection
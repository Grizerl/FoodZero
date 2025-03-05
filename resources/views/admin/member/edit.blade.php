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
   <form action="{{ route('members.update',$users['id']) }}" method="post">
         @csrf
         @method('PATCH')
         <div class="form-group">
            <label for="Name">User Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter the user name" value="{{ old('name',$users['name']) }}">
            @error('name')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Email address">Email address</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$users['email']) }}" placeholder="Enter the email address">
            @error('email')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
         <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password',$users['password']) }}" placeholder="Enter the password">
            @error('password')
               <div style="text-align: center; margin-top: 10px;" class="alert-danger">{{ $message }}</div>
            @enderror
         </div>
   </div>
   <div class="card-footer">
      <button type="submit" class="btn btn-primary">Create user</button>
   </div>
</form>
@endsection
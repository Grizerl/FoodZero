<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function showform()
   {
      return view('auth.login');
   }

   public function login(AuthRequest $authRequest)
   {
      $credentials=$authRequest->only('email','password');
      
      if(Auth::attempt($credentials)) {
         return redirect()->route('dashboard');
      }

      return back()->withErrors([
         'message' => 'Incorrectly entered data',
      ]);
   }

   public function dashboard()
   {
      $count_user=User::count();
      $count_menu=Menu::count();
      $count_blog=Post::count();
      $count_reservation=Reservation::count();
      return view('dashboard',compact('count_user','count_menu','count_blog','count_reservation'));
   }

   public function logout()
   {
      Auth::logout();
      return redirect()->route('showform');
   }
}




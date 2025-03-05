<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function showform()
   {
      return view('auth.login');
   }

   public function login(AuthRequest $authRequest)
   {

      $credentials=$authRequest->only('email','password');
      
      if(Auth::attempt($credentials)) 
      {
         return redirect()->route('dashboard');
      }

      return redirect()->back()->with('message','Incorrectly entered data');
   }

   public function dashboard()
   {
      return view('admin.dashboard')->with([
         'count_user' => User::count(),
         'count_menu' => Menu::count(),
         'count_blog' => Post::count(),
         'count_reservation' => Reservation::count()
     ]);
     
   }

   public function logout()
   {
      Auth::logout();
      return redirect()->route('showform');
   }
}




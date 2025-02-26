<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
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
      return view('dashboard');
   }

   public function logout()
   {
      Auth::logout();

      return redirect()->route('showform');
   }
}




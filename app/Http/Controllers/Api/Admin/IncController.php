<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;


class IncController extends Controller
{
    // public function register(RegisterRequest $request)
    // {
    //     return User::create($request->all());
    // }
    
    // public function login(AuthRequest $authRequest) {
    //     if (!Auth::attempt($authRequest->only('email', 'password'))) {
    //         return response()->json([
    //             'message' => 'Wrong email or password'
    //         ], 401);
    //     }
    
    //     $user = Auth::user();
    
    //     return response()->json([
    //         'user' => [
    //             'id' => $user->id,
    //             'name' => $user->name,
    //             'email' => $user->email,
    //         ],
    //         'token' => $user->createToken("Token of user {$user->name}")->plainTextToken
    //     ]);
    // }

    // public function logout()
    // {
    //     Auth::user()->currentAccessToken()->delete();

    //     return response()->json([
    //         'message' => 'Token removed'
    //     ]);
    // }
    
 
} 

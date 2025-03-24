<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\IncRequest;
use Illuminate\Support\Facades\Auth;

class IncController extends Controller
{
    public function login(IncRequest $incRequest) {

        if(!Auth::attempt($incRequest->only('email','password'))) {
            return response()->json([
                'message' => 'Wrong email or password'
            ], 401);
        }

        $user=Auth::user();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken("Token create {$user->name}")->plainTextToken
        ]);

    }

    public function logout() {
        Auth::user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Log out',
        ]);
    }
}



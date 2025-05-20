<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\IncRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class IncController extends Controller
{
    /**
     * Summary of login
     * @param \App\Http\Requests\Api\Admin\IncRequest $incRequest
     * @return JsonResponse|mixed
     */
    public function login(IncRequest $incRequest): JsonResponse
    {

        if (!Auth::attempt($incRequest->validated())) {
            return response()->json([
                'message' => 'Wrong email or password'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken("Token create {$user->name}")->plainTextToken
        ]);

    }

    /**
     * Summary of logout
     * @return JsonResponse|mixed
     */
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Log out',
        ]);
    }
}

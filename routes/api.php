<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/menu-items', [ApiController::class, 'menu']);

Route::get('/full-menu', [ApiController::class, 'fullMenu']);

Route::get('/blog', [ApiController::class, 'blog']);

Route::get('/post/{id}', [ApiController::class, 'post']);
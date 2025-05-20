<?php

use App\Http\Controllers\Api\Admin\IncController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\MenuController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\ReservationController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request): User {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/menu-items', [ApiController::class, 'menu']);

Route::get('/full-menu', [ApiController::class, 'fullMenu']);

Route::get('/blog', [ApiController::class, 'blog']);

Route::get('/post/{id}', [ApiController::class, 'post']);

Route::prefix('admin')->group(function (): void {
    Route::post('login', [IncController::class, 'login']);
});

Route::prefix('dashboard')->middleware(['auth:sanctum'])->group(function (): void {

    Route::apiResource('posts', PostController::class);

    Route::resource('team', TeamController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('menu', MenuController::class);

    Route::resource('reservation', ReservationController::class);

    Route::middleware('auth:sanctum')->get('logout', [IncController::class, 'logout']);

});

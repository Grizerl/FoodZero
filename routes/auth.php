<?php

use App\Http\Controllers\Admin\Dashboard\HomeController;
use App\Http\Controllers\Admin\Pages\CategoryController;
use App\Http\Controllers\Admin\Pages\MenuController;
use App\Http\Controllers\Admin\Pages\PostController;
use App\Http\Controllers\Admin\Pages\ReservationController;
use App\Http\Controllers\Admin\Pages\UsersController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', 'throttle:5,1'])->prefix('admin')->group(function () {

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login.form');

    Route::post('login', [AuthController::class, 'login'])->name('admin.login.submit');

});

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {

    Route::get('/', [HomeController::class, 'home'])->name('dashboard');

    Route::resource('post', PostController::class);

    Route::resource('members', UsersController::class);

    Route::resource('category', CategoryController::class);

    Route::resource('menu', MenuController::class);

    Route::resource('reservation', ReservationController::class);

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

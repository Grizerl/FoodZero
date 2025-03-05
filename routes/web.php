<?php

use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UsersController;
use App\Models\Reservation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home.page');
});

Route::fallback(function () {
    return redirect()->route('home.page');
});

Route::prefix('FoodZero')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.page');
    Route::get('Menu', [HomeController::class, 'menu'])->name('menu.page');
    Route::get('Blog', [HomeController::class, 'blog'])->name('blog.page');
    Route::get('About', [HomeController::class, 'about'])->name('about.page');
    Route::get('Contact', [HomeController::class, 'contact'])->name('contact.page');
});

Route::prefix('Admin')->group(function () {
    Route::get('FormLogin', [AuthController::class, 'showform'])->name('showform');
    Route::post('Login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth')->group(function () {
        Route::get('Dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::resource('post', PostController::class);
        Route::resource('menu', MenuController::class);
        Route::resource('reservation', ReservationController::class);
        Route::resource('members',UsersController::class);
        Route::post('Logout', [AuthController::class, 'logout'])->name('logout');
    });
});

<?php

use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckAuthentication;
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
    Route::get('FormLogin',[App\Http\Controllers\Auth\AuthController::class, 'showform'])->name('showform');
    Route::post('Login',[App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
   
    Route::middleware('auth')->group(function() {
        Route::get('Dashboard', [App\Http\Controllers\Auth\AuthController::class, 'dashboard'])->name('dashboard');
        Route::post('Logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
        Route::resource('menu', App\Http\Controllers\Admin\MenuController::class);
        Route::resource('post',App\Http\Controllers\Admin\PostController::class);
    });
}); 
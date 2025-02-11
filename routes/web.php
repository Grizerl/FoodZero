<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "hello";
});

Route::get('/',[HomeController::class ,'index'])->name('home.page');

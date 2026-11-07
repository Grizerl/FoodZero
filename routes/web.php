<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.page');

Route::get('menu', [HomeController::class, 'menu'])->name('menu.page');

Route::get('menu/full', [HomeController::class, 'fullMenu'])->name('fullMenu.page');

Route::post('reservation', [HomeController::class, 'reservation'])->middleware('throttle:reservation-submit')->name('reservation.submit');

Route::get('reservation/slots', [HomeController::class, 'reservationSlots'])->middleware('throttle:reservation-slots')->name('reservation.slots');

Route::get('blog', [HomeController::class, 'blog'])->name('blog.page');

Route::get('blog/{id}/detail', [HomeController::class, 'show'])->name('post.details.page');

Route::get('about', [HomeController::class, 'about'])->name('about.page');

Route::get('contact', [HomeController::class, 'contact'])->name('contact.page');

require __DIR__.'/auth.php';

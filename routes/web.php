<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
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

Route::post('newsletter', [NewsletterController::class, 'subscribe'])->middleware('throttle:newsletter-subscribe')->name('newsletter.subscribe');

Route::get('newsletter/confirm/{subscriber}', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');

Route::match(['get', 'post'], 'newsletter/unsubscribe/{subscriber}', [NewsletterController::class, 'unsubscribe'])->middleware('signed')->name('newsletter.unsubscribe');

require __DIR__.'/auth.php';

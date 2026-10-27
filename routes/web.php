<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/index.php', [HomeController::class, 'handleLegacyQuery'])->name('legacy.entry');

Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/category/{category}', [WorkController::class, 'category'])->name('work.category');
Route::get('/work/{work}', [WorkController::class, 'show'])->name('work.show');

Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

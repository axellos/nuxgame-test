<?php

declare(strict_types=1);

use App\Http\Controllers\GameLinkController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegisterController::class, 'show'])->name('register.page');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/link/{token}', [GameLinkController::class, 'show'])->name('link.page');

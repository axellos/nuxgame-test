<?php

declare(strict_types=1);

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameLinkController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegisterController::class, 'show'])->name('register.page');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::prefix('games/{token}')->middleware(['game-link.verify'])->group(function () {
    Route::get('/', [GameController::class, 'show'])->name('game.page');
    Route::post('play', [GameController::class, 'play'])->name('game.play');
    Route::get('history', [GameController::class, 'history'])->name('game.history');
});

Route::prefix('game-links/{token}')->middleware(['game-link.verify'])->group(function () {
    Route::post('regenerate', [GameLinkController::class, 'generate'])->name('game-link.generate');
    Route::delete('', [GameLinkController::class, 'destroy'])->name('game-link.destroy');
});

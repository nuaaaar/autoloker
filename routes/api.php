<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\RefreshTokenController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class)->name('api.login');
Route::post('/refresh-token', RefreshTokenController::class)->name('api.refresh-token');
Route::middleware('api.token')->group(function () {
    Route::get('/me', MeController::class)->name('api.me');
    Route::post('/logout', LogoutController::class)->name('api.logout');
});

Route::post('/register', RegisterController::class)->name('api.register');

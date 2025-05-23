<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::get('user', 'userProfile');
        Route::post('logout', 'userLogout');
    });

    Route::prefix('chatbot')->controller(ChatbotController::class)->group(function () {
        Route::post('message', 'sendMessage');
        Route::get('history', 'history');
    });
});

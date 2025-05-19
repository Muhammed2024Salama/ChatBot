<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', 'userProfile');
        Route::get('logout', 'userLogout');

        Route::post('/chatbot/message', [ChatbotController::class, 'sendMessage']);
        Route::get('/chatbot/history', [ChatbotController::class, 'history']);
    });
});

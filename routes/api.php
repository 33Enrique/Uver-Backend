<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'sendVerificationCode']);
Route::post('/verify', [AuthController::class, 'verifyCode']);
Route::post('/register', [UserController::class, 'store']);

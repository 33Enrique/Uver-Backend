<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {return view('welcome');});
Route::get('/register', [UserController::class, 'create'])->name('users.create');
Route::post('/register', [UserController::class, 'store'])->name('users.store');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'sendVerificationCode'])->name('auth.send_code');
Route::get('/verify', [AuthController::class, 'showVerificationForm'])->name('auth.verify');
Route::post('/verify', [AuthController::class, 'verifyCode'])->name('auth.verify_code');


/*
Route::post('/login', [AuthController::class, 'sendVerificationCode']);
Route::get('/login', [AuthController::class, 'sendVerificationCode']);
Route::post('/verify', [AuthController::class, 'verifyCode']);
Route::get('/verify', [AuthController::class, 'verifyCode']);
*/


Route::get('/home', function () {return view('home');})->name('home')->middleware('auth');
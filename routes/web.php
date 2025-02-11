<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/register', function () {
    return view('register');
})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register');

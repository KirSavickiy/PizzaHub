<?php

use App\Http\Controllers\User\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart', [CartController::class, 'index']);
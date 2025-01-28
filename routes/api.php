<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::get('/cart', [CartController::class, 'getCart'])->middleware(App\Http\Middleware\OptionalAuth::class);
Route::post('/cart/add', [CartController::class, 'addToCart'])->middleware(App\Http\Middleware\OptionalAuth::class);
Route::post('/cart', [CartController::class, 'createCart'])->middleware(App\Http\Middleware\OptionalAuth::class);
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->middleware(App\Http\Middleware\OptionalAuth::class);





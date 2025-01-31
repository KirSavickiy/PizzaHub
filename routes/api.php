<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


Route::middleware('guest')->post('/login', [AuthController::class, 'login']);
Route::middleware('guest')->post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::get('/cart', [CartController::class, 'getCart'])->middleware('guest_or_authenticated');
Route::post('/cart/add', [CartController::class, 'addToCart'])->middleware('guest_or_authenticated');
Route::post('/cart', [CartController::class, 'createCart'])->middleware('guest_or_authenticated');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->middleware('guest_or_authenticated');
Route::put('/cart/update/{id}', [CartController::class, 'updateItem'])->middleware('guest_or_authenticated');

Route::get('/addresses', [AddressController::class, 'index'])->middleware('auth:sanctum');
Route::post('/addresses', [AddressController::class, 'store'])->middleware('auth:sanctum');
Route::get('/addresses/{id}', [AddressController::class, 'show'])->middleware('auth:sanctum');
Route::put('/addresses/{id}', [AddressController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
Route::get('/orders/{id}', [OrderController::class, 'show'])->middleware('auth:sanctum');
Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');



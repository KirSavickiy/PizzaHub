<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\Address\AddressController;
use App\Http\Controllers\User\Cart\CartController;
use App\Http\Controllers\User\Category\CategoryController;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\User\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);


Route::middleware('check.user.auth')->group(function () {
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart', [CartController::class, 'createCart']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem']);
    Route::put('/cart/update/{id}', [CartController::class, 'updateItem']);
});

Route::middleware('auth:sanctum')->apiResource('addresses', AddressController::class);

Route::middleware('auth:sanctum')->apiResource('orders', OrderController::class)->only(['index', 'show', 'store']);

require __DIR__.'/admin.php';

<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\Address\AddressController;
use App\Http\Controllers\User\Cart\CartController;
use App\Http\Controllers\User\Category\CategoryController;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\User\Product\ProductController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('addresses', AddressController::class);
    Route::apiResource('orders', OrderController::class)->only(['index', 'show', 'store']);
});

// Public routes (available to everyone)
Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);

// Cart Routes
Route::middleware('check.user.auth')->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'getCart']);
    Route::post('/', [CartController::class, 'createCart']);
    Route::post('/add', [CartController::class, 'addToCart']);
    Route::delete('/remove/{id}', [CartController::class, 'removeItem']);
    Route::put('/update/{id}', [CartController::class, 'updateItem']);
});

// Admin Routes
require __DIR__.'/admin.php';
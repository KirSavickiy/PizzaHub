<?php

use App\Http\Controllers\Admin\Product\ProductController as AdminProductController;
use App\Http\Controllers\Admin\Category\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Order\OrderController as AdminOrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProductController;
use Illuminate\Support\Facades\Route;


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

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::put('/products/{id}', [AdminProductController::class, 'update']);
    Route::put('/product_items/{id}', [AdminProductController::class, 'updateItem']);
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);
    Route::delete('/product_items/{id}', [AdminProductController::class, 'destroyItem']);

    Route::post('/categories', [AdminCategoryController::class, 'store']);
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update']);
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'changeStatus']);

});

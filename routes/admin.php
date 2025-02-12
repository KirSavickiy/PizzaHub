<?php

use App\Http\Controllers\Admin\Category\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Order\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\Product\ProductController as AdminProductController;
use App\Http\Controllers\Admin\Product\ProductItemController as AdminProductItemController;
use App\Http\Controllers\User\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('products', AdminProductController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('product/items', AdminProductItemController::class)->only(['update', 'destroy']);

    Route::apiResource('categories', AdminCategoryController::class)->only(['store', 'update', 'destroy']);

    Route::post('/orders/{id}/status', [AdminOrderController::class, 'changeStatus']);
    Route::apiResource('orders', OrderController::class)->only(['index', 'show']);
});

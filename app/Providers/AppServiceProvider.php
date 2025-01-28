<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use App\Services\Cart\CartServiceInterface;
use App\Services\Cart\CartService;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Cart\CartItemRepositoryInterface;
use App\Repositories\Cart\CartItemRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Cart\CartValidatorService;
use App\Services\Cart\CartValidatorServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Models\CartItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartItemRepositoryInterface::class, CartItemRepository::class);
        $this->app->bind(CartValidatorServiceInterface::class, CartValidatorService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}

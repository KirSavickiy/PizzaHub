<?php

namespace App\Providers;

use App\Services\Cart\CartServiceInterface;
use App\Services\Cart\CartService;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

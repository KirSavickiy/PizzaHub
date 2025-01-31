<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Events\UserRegistered;
use App\Listeners\Cart\TransferGuestCartToUserCart;
use App\Listeners\Order\CreateOrderItems;
use App\Repositories\Cart\CartItemRepository;
use App\Repositories\Cart\CartItemRepositoryInterface;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Cart\CartService;
use App\Services\Cart\CartServiceInterface;
use App\Services\Order\OrderService;
use App\Services\Order\OrderServiceInterface;
use App\Services\Validators\CartValidatorService;
use App\Services\Validators\CartValidatorServiceInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

    protected array $listen = [
        UserRegistered::class => [
            TransferGuestCartToUserCart::class,
        ],
        OrderCreated::class => [
            CreateOrderItems::class,
        ]
    ];
}

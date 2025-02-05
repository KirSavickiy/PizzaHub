<?php

namespace App\Actions\User\Cart;

use App\Models\Cart;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Cart\CartServiceInterface;
use App\Services\Validators\CartValidatorServiceInterface;
use Illuminate\Http\RedirectResponse;

abstract class CartAction
{
    protected CartServiceInterface $cartService;
    protected AuthService $authService;
    protected CartValidatorServiceInterface $cartValidatorService;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(CartServiceInterface $cartService, AuthService $authService, CartValidatorServiceInterface $cartValidatorService, ProductRepositoryInterface $productRepository)
    {
        $this->cartService = $cartService;
        $this->authService = $authService;
        $this->cartValidatorService = $cartValidatorService;
        $this->productRepository = $productRepository;
    }

    protected function getCart(?string $cartId = null): ?Cart
    {
        if ($this->authService->isAuthenticated()) {
            return $this->cartService->getCartForAuthenticatedUser();
        }

        if ($cartId) {
            return $this->cartService->getCartForGuest($cartId);
        }

        return null;
    }

}
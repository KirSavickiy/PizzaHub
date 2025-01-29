<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Services\Auth\AuthService;
use App\Services\Cart\CartServiceInterface;
use App\Services\Cart\CartValidatorServiceInterface;

abstract class CartAction
{
    protected CartServiceInterface $cartService;
    protected AuthService $authService;
    protected CartValidatorServiceInterface $cartValidatorService;

    public function __construct(CartServiceInterface $cartService, AuthService $authService, CartValidatorServiceInterface $cartValidatorService)
    {
        $this->cartService = $cartService;
        $this->authService = $authService;
        $this->cartValidatorService = $cartValidatorService;
    }

    protected function getCart(?string $cartId = null): ?Cart
    {
        return $this->authService->isAuthenticated()
            ? $this->cartService->getCartForAuthenticatedUser()
            : ($cartId ? $this->cartService->getCartForGuest($cartId) : null);
    }
}
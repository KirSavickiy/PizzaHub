<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Cart\CartServiceInterface;
use Illuminate\Http\JsonResponse;

abstract class CartAction
{
    protected CartServiceInterface $cartService;
    protected AuthService $authService;
    protected CartRepositoryInterface $cartRepository;

    public function __construct(CartServiceInterface $cartService, AuthService $authService, CartRepositoryInterface $cartRepository)
    {
        $this->cartService = $cartService;
        $this->authService = $authService;
        $this->cartRepository = $cartRepository;
    }

    protected function getCart(?string $cartId = null): ?Cart
    {
        if ($this->authService->isAuthenticated()) {
            return $this->cartService->getCartForAuthenticatedUser();
        }

        if ($cartId === null) {
            return null;
        }
        return $this->cartService->getCartForGuest($cartId);
    }

}
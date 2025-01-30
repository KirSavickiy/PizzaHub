<?php

namespace App\Services\Cart;

use App\Repositories\Cart\CartRepositoryInterface;

class CartTransferService
{
    protected CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }
    public function transferGuestCartToUserCart(string $sessionId, int $userId): void
    {
        $cart = $this->cartRepository->getCartBySessionId($sessionId);
        $cart->update([
            'user_id' => $userId,
            'session_id' => null,
        ]);
    }
}
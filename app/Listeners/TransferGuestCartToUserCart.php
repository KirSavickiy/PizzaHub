<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Cart;
use App\Services\Cart\CartTransferService;

class TransferGuestCartToUserCart
{
    protected CartTransferService $cartTransferService;

    /**
     * Create the event listener.
     */
    public function __construct(CartTransferService $cartTransferService)
    {
        $this->cartTransferService = $cartTransferService;
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;
        $cartId = request()->query('cart-id');

        $userCart = $user->cart()->first();

        if ($cartId) {
            $guestCart = Cart::where('session_id', $cartId)->first();
            if ($guestCart) {
                $this->cartTransferService->transferGuestCartToUserCart($cartId, $user->id);
            }
        } elseif (!$userCart) {
            $user->cart()->create();
        }
    }
}

<?php

namespace App\Listeners\Cart;

use App\Events\OrderCreated;
use App\Exceptions\Order\OrderCreationException;
use Illuminate\Support\Facades\Log;

class ClearUserCartAfterOrder
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     * @throws OrderCreationException
     */
    public function handle(OrderCreated $event): void
    {
        $user = $event->order->user;

        try{
            $cart  = $user->cart;
            if($cart){
                $cart->items()->delete();
            }
        } catch (\Exception $e){
            Log::error('Clean Cart failed: ', [
                'order_id' => $event->order->id,
                'error' => $e->getMessage(),
            ]);
            throw new OrderCreationException("Failed to clean cart" . $e->getMessage(), 500);
        }
    }
}

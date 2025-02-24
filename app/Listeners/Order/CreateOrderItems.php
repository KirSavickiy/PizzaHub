<?php

namespace App\Listeners\Order;

use App\Events\OrderCreated;
use App\Exceptions\Order\OrderCreationException;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CreateOrderItems
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
        try {
            DB::beginTransaction();
            $order = $event->order;
            $cartItems = $order->user->cart->items()->get();

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_item_id' => $cartItem->product_item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new OrderCreationException("Failed to create order items" . $e->getMessage(), 500);
        }
    }
}

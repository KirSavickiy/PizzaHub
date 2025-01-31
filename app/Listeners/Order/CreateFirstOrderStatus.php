<?php

namespace App\Listeners\Order;

use App\Events\OrderCreated;
use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Order\OrderCreationException;
use App\Models\OrderStatusHistory;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Log;

class CreateFirstOrderStatus
{
    /**
     * Create the event listener.
     */
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * Handle the event.
     * @throws AuthenticationException
     * @throws OrderCreationException
     */
    public function handle(OrderCreated $event): void
    {
        try {
            $order = $event->order;
            $userId = $this->authService->getAuthenticatedUserId();
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'old_status' => 'new',
                'new_status' => 'new',
                'changed_by' => "$userId",
                'changed_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Order Status creation failed: ', [
                'order_id' => $event->order->id,
                'error' => $e->getMessage(),
            ]);

            throw new OrderCreationException("Failed to create order status" . $e->getMessage(), 500);
        }
    }
}
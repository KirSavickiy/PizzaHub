<?php

namespace App\Actions\Order;

use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Cart\EmptyCartException;
use App\Exceptions\Order\OrderCreationException;
use App\Http\Resources\Order\OrderResource;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;

class CreateOrderAction
{
    public function __construct(protected OrderService $orderService) {}

    /**
     * @throws AuthenticationException
     * @throws OrderCreationException
     * @throws EmptyCartException
     */
    public function handle(array $data): JsonResponse
    {
        $order = $this->orderService->createOrder($data);
        $order->load('items');
        return response()->json([
            'status' => 'success',
            'message' => 'Order successfully created',
            'data' => new OrderResource($order),
        ], 201);
    }
}

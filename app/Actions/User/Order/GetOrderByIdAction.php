<?php

namespace App\Actions\User\Order;

use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Order\GetOrdersException;
use App\Http\Resources\Order\OrderResource;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class GetOrderByIdAction
{
    public function __construct(protected OrderService $orderService) {}

    /**
     * @throws AuthenticationException
     * @throws GetOrdersException
     * @throws ValidationException
     */
    public function handle(string $id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);
        $order->load('items');
        return response()->json([
            'success' => true,
            'data' => new OrderResource($order),
            'message' => 'Order retrieved successfully',
        ], 200);
    }
}
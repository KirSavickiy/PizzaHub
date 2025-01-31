<?php

namespace App\Actions\Order;

use App\Http\Resources\Order\OrderResource;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;

class GetOrderByIdAction
{
    public function __construct(protected OrderService $orderService) {}

    public function handle(int $id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);
        return response()->json([
            'success' => true,
            'data' => new OrderResource($order),
            'message' => 'Order retrieved successfully',
        ], 200);
    }
}
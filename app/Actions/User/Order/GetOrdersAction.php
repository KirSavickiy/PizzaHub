<?php

namespace App\Actions\User\Order;

use App\Exceptions\Order\GetOrdersException;
use App\Http\Resources\Order\OrderResource;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;

class GetOrdersAction
{
    public function __construct(protected OrderService $orderService) {}

    /**
     * @throws GetOrdersException
     */
    public function handle():JsonResponse
    {
        $orders = $this->orderService->getOrders();

        return response()->json([
            'success' => true,
            'data' => OrderResource::collection($orders),
            'message' => 'Orders retrieved successfully',
        ], 200);
    }

}
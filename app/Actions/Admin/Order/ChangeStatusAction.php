<?php

namespace App\Actions\Admin\Order;

use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\General\CreationException;
use App\Exceptions\Order\GetOrdersException;
use App\Http\Resources\Order\OrderResource;
use App\Services\Auth\AuthService;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ChangeStatusAction
{
    public function __construct(protected OrderService $orderService, protected AuthService $authService) {}

    /**
     * @throws GetOrdersException
     * @throws AuthenticationException
     * @throws ValidationException
     * @throws CreationException
     */
    public function handle(array $data, string $id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);
        $userId = $this->authService->getAuthenticatedUserId();

        try{
            $order->statuses()->create([
                'order_id' => $order->id,
                'old_status' => $order->statuses()->latest()->first()->new_status,
                'new_status' => $data['status'],
                'comment' => $data['comment'] ?? null,
                'changed_by' => $userId,
                'changed_at' => now(),
            ]);

        }catch (\Exception $e){
            throw new CreationException($e->getMessage());
        }

        return response()->json([
            'success' => true,
            'data' => new OrderResource($order),
            'message' => 'Order status has been successfully changed.',
        ], 200);

    }
}
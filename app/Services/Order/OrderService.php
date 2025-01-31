<?php

namespace App\Services\Order;

use App\Events\OrderCreated;
use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Cart\EmptyCartException;
use App\Exceptions\Order\GetOrdersException;
use App\Exceptions\Order\OrderCreationException;
use App\Models\Order;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Cart\CartServiceInterface;
use App\Services\Validators\IdValidatorService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;


class OrderService implements OrderServiceInterface
{
    public function __construct(
        protected AuthService $authService,
        protected CartServiceInterface $cartService,
        protected CartRepositoryInterface $cartRepository,
    ) {}

    /**
     * @throws AuthenticationException
     * @throws OrderCreationException
     * @throws EmptyCartException
     */
    public function createOrder(array $data): Order
    {
        $userId = $this->authService->getAuthenticatedUserId();
        $cart = $this->cartRepository->getCartByUserId($userId);
        $cartItems = $cart->items()->get();

        if ($cartItems->isEmpty()) {
            throw new EmptyCartException();
        }

        $totalPrice = $this->cartService->calculateTotalPrice($cart);

        $data['user_id'] = $userId;
        $data['total_price'] = $totalPrice;

        try {
            $order = Order::create($data);
            event(new OrderCreated($order));
            return $order;
        } catch (QueryException $e) {
            throw new OrderCreationException("Failed to create order" . $e->getMessage(), 500);
        }
    }

    /**
     * @throws AuthenticationException
     * @throws GetOrdersException
     */
    public function getOrders(): Collection
    {
        try {
            return Order::where('user_id', $this->authService->getAuthenticatedUserId())->get();
        } catch (QueryException) {
            throw new GetOrdersException("Failed to get orders", 500);
        }
    }

    /**
     * @throws AuthenticationException
     * @throws ValidationException
     * @throws GetOrdersException
     */
    public function getOrderById(int $id): Order
    {
        $id = IdValidatorService::validateId($id, 'orders');
        $order = Order::where('id', $id)
            ->where('user_id', $this->authService->getAuthenticatedUserId())->get()
            ->first();
        if (!$order) {
            throw new GetOrdersException("Order with id {$id} not found", 404);
        }
        return $order;
    }
}
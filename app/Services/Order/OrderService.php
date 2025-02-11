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
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class OrderService implements OrderServiceInterface
{
    public function __construct(
        protected AuthService $authService,
        protected CartServiceInterface $cartService,
        protected CartRepositoryInterface $cartRepository,
    ) {}

    /**
     * @throws AuthenticationException|OrderCreationException|EmptyCartException
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
     * @throws GetOrdersException
     */
    public function getOrders(): Collection
    {
        try{
            $user = Auth::user();
            if ($user->can('view', Order::class)) {
                return Order::all();
            }
            return Order::where('user_id', $user->id)->get();
        }catch (QueryException){
            throw new GetOrdersException("Failed to get orders", 500);
        }
    }

    /**
     * @throws AuthenticationException|ValidationException|GetOrdersException
     */
    public function getOrderById(string $id): Order
    {
        $id = IdValidatorService::validateId($id, 'orders');
        $user = Auth::user();

        $order = Order::find($id);

        if (!$order) {
            throw new GetOrdersException("Order with id {$id} not found", 404);
        }

        if ($user->can('viewOwnOrder', $order)) {
            if ($order->user_id !== $this->authService->getAuthenticatedUserId()) {
                throw new GetOrdersException("You do not have permission to view this order", 403);
            }
            return $order;
        }

        if ($user->can('view', Order::class)) {
            return $order;
        }

        throw new GetOrdersException("You do not have permission to view this order", 403);
    }
}
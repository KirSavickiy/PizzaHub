<?php

namespace App\Services\Order;

use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Auth\ValidationException;
use App\Exceptions\Cart\EmptyCartException;
use App\Exceptions\Order\GetOrdersException;
use App\Exceptions\Order\OrderCreationException;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface OrderServiceInterface
 *
 * Defines the contract for handling orders within the system.
 */
interface OrderServiceInterface
{
    /**
     * Creates a new order based on the provided data.
     *
     * @param array $data Order details (e.g., delivery address, payment method).
     * @return Order The created order.
     *
     * @throws AuthenticationException If the user is not authenticated.
     * @throws EmptyCartException If the cart is empty.
     * @throws OrderCreationException If order creation fails.
     */
    public function createOrder(array $data): Order;

    /**
     * Retrieves a collection of orders.
     *
     * If the user has permission, all orders will be returned; otherwise, only the orders belonging to the authenticated user.
     *
     * @return Collection A collection of orders.
     *
     * @throws GetOrdersException If retrieving orders fails.
     */
    public function getOrders(): Collection;

    /**
     * Retrieves a specific order by its ID.
     *
     * @param string $id The ID of the order.
     * @return Order The requested order.
     *
     * @throws AuthenticationException If the user is not authenticated.
     * @throws ValidationException If the order ID is invalid.
     * @throws GetOrdersException If the order is not found or access is denied.
     */
    public function getOrderById(string $id): Order;
}

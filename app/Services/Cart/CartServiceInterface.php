<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;

/**
 * Interface for managing shopping carts.
 */
interface CartServiceInterface
{
    /**
     * Create a new cart instance (e.g., for a guest).
     *
     * @return Cart Newly created cart instance.
     */
    public function createNewCart(): Cart;

    /**
     * Retrieve the cart for an authenticated user.
     *
     * @return Cart The cart instance for the authenticated user.
     */
    public function getCartForAuthenticatedUser(): Cart;

    /**
     * Retrieve the cart for a guest.
     *
     * @param string $cartId The ID of the guest cart.
     * @return Cart The cart instance for the guest.
     */
    public function getCartForGuest(string $cartId): Cart;

    /**
     * Add a product to the cart.
     *
     * @param int $productId The ID of the product to add.
     * @param int $quantity  The quantity to add.
     * @return void
     */
    public function addProduct(int $productId, int $quantity): CartItem;

    /**
     * Remove a product from the cart.
     *
     * @param int $productId The ID of the product to remove.
     * @return void
     */
    public function removeProduct(int $productId): void;

    /**
     * Update the quantity of a product in the cart.
     *
     * @param int $productId The ID of the product to update.
     * @param int $quantity  The new quantity.
     * @return void
     */
    public function updatedQuantity(int $productId, int $quantity): void;

    /**
     * Calculate the total price of the cart.
     *
     * @param Cart $cart The cart instance.
     * @return float The total price of the cart.
     */
    public function calculateTotalPrice(Cart $cart): float;

}
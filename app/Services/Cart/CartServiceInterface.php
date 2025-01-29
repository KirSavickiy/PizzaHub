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
    public function createNewGuestCart(): Cart;


    /**
     * Retrieve the cart for an authenticated user.
     *
     * @return Cart The cart instance for the authenticated user.
     */
    public function getCartForAuthenticatedUser(): Cart;

    /**
     * Retrieve the cart for a guest.
     *
     * @param string $sessionId The ID of the guest cart.
     * @return Cart The cart instance for the guest.
     */
    public function getCartForGuest(string $sessionId): Cart;

    /**
     * Add a product to the cart.
     *
     * @param Cart $cart The cart instance.
     * @param int $productId The ID of the product to add.
     * @param int $quantity  The quantity to add.
     * @return CartItem
     */
    public function addProduct(Cart $cart, int $productId, int $quantity): CartItem;

    /**
     * Remove a product from the cart.
     * @param Cart $cart The cart instance.
    * @param int $id The ID of the product to remove.
     * @return bool
     */
    public function removeProduct(Cart $cart, int $item_id): ?CartItem;

    /**
     * Update the quantity of a product in the cart.
     *
     * @param int $productId The ID of the product to update.
     * @param int $quantity  The new quantity.
     * @return void
     */
    public function updatedQuantity(Cart $cart, int $item_id, int $quantity): ?CartItem;

    /**
     * Calculate the total price of the cart.
     *
     * @param Cart $cart The cart instance.
     * @return float The total price of the cart.
     */
    public function calculateTotalPrice(Cart $cart): float;

}
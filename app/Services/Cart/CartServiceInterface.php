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
     * Creates a new guest cart.
     *
     * @return Cart The created cart instance.
     */
    public function createNewGuestCart(): Cart;

    /**
     * Retrieves the cart for an authenticated user.
     *
     * @return Cart The cart associated with the authenticated user.
     */
    public function getCartForAuthenticatedUser(): Cart;

    /**
     * Retrieves the cart for a guest using the session ID.
     *
     * @param string $sessionId The guest session ID.
     * @return Cart The guest cart instance.
     */
    public function getCartForGuest(string $sessionId): Cart;

    /**
     * Adds a product to the cart.
     *
     * @param Cart $cart The cart instance.
     * @param int $productId The product ID.
     * @param int $quantity The quantity to add.
     * @return CartItem The added cart item.
     */
    public function addProduct(Cart $cart, int $productId, int $quantity): CartItem;

    /**
     * Removes a product from the cart.
     *
     * @param Cart $cart The cart instance.
     * @param string $id The cart item ID.
     * @return CartItem The removed cart item.
     */
    public function removeProduct(Cart $cart, string $id): CartItem;

    /**
     * Updates the quantity of a product in the cart.
     *
     * @param Cart $cart The cart instance.
     * @param string $id The cart item ID.
     * @param int $quantity The new quantity.
     * @return CartItem The updated cart item.
     */
    public function updateQuantity(Cart $cart, string $id, int $quantity): CartItem;

    /**
     * Calculates the total price of the cart.
     *
     * @param Cart $cart The cart instance.
     * @return float The total price of all items in the cart.
     */
    public function calculateTotalPrice(Cart $cart): float;
}

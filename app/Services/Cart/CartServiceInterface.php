<?php

namespace App\Services\Cart;

use App\Models\Cart;

interface CartServiceInterface
{
    public function getCart();
    public function addProduct(int $productId, int $quantity);
    public function removeProduct(int $productId);
    public function updatedQuantity(int $productId, int $quantity);
    public function calculateTotalPrice(Cart $cart);

}
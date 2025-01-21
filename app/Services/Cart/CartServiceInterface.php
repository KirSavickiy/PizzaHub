<?php

namespace App\Services\Cart;

use Illuminate\Http\Request;

interface CartServiceInterface
{
    public function getCart();
    public function addProduct(int $productId, int $quantity);
    public function removeProduct(int $productId);
    public function updatedQuantity(int $productId,int $quantity);

}
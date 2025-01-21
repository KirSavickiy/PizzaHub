<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\ProductItem;
use App\Services\Auth\AuthCheckService;

class CartService implements CartServiceInterface
{
    protected $cart;
    protected $authCheckService;
    public function __construct(Cart $cart, AuthCheckService $authCheckService)
    {
        $this->authCheckService = $authCheckService;
        $this->cart = $cart;
    }
    public function getCart(): Cart
    {
        if ($this->authCheckService->isAuthenticated()) {
            return $this->cart->firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_id' => null]
            );
        } else {
            return $this->cart->firstOrCreate(
                ['session_id' => session()->getId()],
                ['user_id' => null]
            );
        }
    }
    public function addProduct(int $productId, int $quantity = 1): void
    {
        $product = ProductItem::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $cart = $this->getCart();
        $item = $cart->items()->where('product_item_id', $productId)->firstOrCreate();
        $item->quantity += $quantity;
        $item->save();
    }
    public function removeProduct(int $productId): void
    {
        $product = ProductItem::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }
        $cart = $this->getCart();
        $item = $cart->items()->where('product_item_id', $productId)->first();
        if ($item) {
            $item->delete();
        }else{
            throw new \Exception('Product not found');
        }
    }

    public function updatedQuantity(int $productId, int $quantity): void
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('product_item_id', $productId)->first();

        if (!$item) {
            throw new \Exception('Product not found in cart');
        }

        if ($quantity === 0) {
            $item->delete();
            return;
        }

        $item->quantity = $quantity;
        $item->save();
    }


}
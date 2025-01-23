<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductItem;
use App\Services\Auth\AuthCheckService;
use Illuminate\Support\Str;


class CartService implements CartServiceInterface
{
    protected Cart $cart;
    protected AuthCheckService $authCheckService;
    public function __construct(Cart $cart, AuthCheckService $authCheckService)
    {
        $this->authCheckService = $authCheckService;
        $this->cart = $cart;
    }

    public function createCart(): Cart
    {
        return $this->cart->create([
            'session_id' => (string) Str::uuid(),
            'user_id' => null,
        ]);
    }
    public function getCart(?string $cartId = null): ?Cart
    {
        if ($this->authCheckService->isAuthenticated()) {
            return $this->getUserCart();
        }

        if ($cartId) {
            return $this->getGuestCart($cartId);
        }

        return null;
    }
    public function addProduct(int $productId, int $quantity = 1, ?string $cartId = null): CartItem
    {
        $product = ProductItem::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $cart = $this->getCart($cartId);

        $item = $cart->items()->where('product_item_id', $productId)->first();

        if (!$item) {
            $item = $cart->items()->create([
                'product_item_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        } else {
            $item->quantity += $quantity;
            $item->save();
        }

        return $item;
    }
    public function removeProduct(int $productId, ?string $cartId = null): void
    {
        $product = ProductItem::find($productId);
        if (!$product) {
            throw new \Exception('Product not found');
        }
        $cart = $this->getCart($cartId);
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
    public function calculateTotalPrice(Cart $cart): float
    {
        $items = $cart->items;

        if ($items->isNotEmpty()) {
            return $items->sum(function ($item) {
                return round($item->price * $item->quantity, 2);
            });
        }

        return 0;
    }

    private function getUserCart(): Cart
    {
        return $this->cart->where('user_id', auth()->id())->firstOrFail();
    }

    private function getGuestCart(string $cartId): Cart
    {
        return $this->cart->where('session_id', $cartId)->firstOrFail();
    }

}
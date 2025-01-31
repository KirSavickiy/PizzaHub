<?php

namespace App\Services\Validators;

use App\Exceptions\Product\ProductOutOfLimitsException;
use App\Exceptions\Product\ProductOutOfStockException;
use App\Models\Cart;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Config;

class CartValidatorService implements CartValidatorServiceInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ProductOutOfStockException
     */
    public function validateStock(Cart $cart, int $id, int $quantity, string $action): void
    {
        $productItem = $this->productRepository->getProductItemById($id);

        $cartQuantity = $cart->items()->where('product_item_id', $id)->sum('quantity');

        $availableStock = $productItem->stock - $cartQuantity;

        if ($action === 'add' && $quantity > $availableStock) {
            throw new ProductOutOfStockException($productItem->product->name, $availableStock);
        }

        if ($action === 'update' && $quantity > $productItem->stock) {
            throw new ProductOutOfStockException($productItem->product->name, $availableStock);
        }
    }

    /**
     * @throws ProductOutOfLimitsException
     */
    public function validateCartLimits(Cart $cart, int $id, int $quantity, string $action): void
    {
        $categories = Config::get('cart.category_limits') ?? [];

        if (!is_array($categories)) {
            return;
        }

        $productItem = $this->productRepository->getProductItemById($id);
        $productCategory = $productItem->product->category?->name;

        if (!$productCategory || !isset($categories[$productCategory])) {
            return;
        }

        $categoryLimit = $categories[$productCategory];

        $itemsInCategory = $cart->items()
            ->whereHas('productItem.product.category', function ($query) use ($productCategory) {
                $query->where('name', $productCategory);
            })
            ->sum('quantity');


        if ($action == 'add' && $itemsInCategory + $quantity > $categoryLimit) {
            throw new ProductOutOfLimitsException($productCategory, $categoryLimit);
        }

        if ($action == 'update' && $quantity > $categoryLimit) {
            throw new ProductOutOfLimitsException($productCategory, $categoryLimit);
        }
    }

}
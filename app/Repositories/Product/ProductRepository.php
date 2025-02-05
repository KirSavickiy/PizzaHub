<?php

namespace App\Repositories\Product;

use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Exceptions\Product\ProductItemNotFoundException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductItem;
use App\Repositories\Cart\CartItemRepository;
use App\Services\Validators\IdValidatorService;
use Illuminate\Validation\ValidationException;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(protected CartItemRepository $cartItemRepository) {}

    /**
     * @throws ValidationException
     * @throws ProductNotFoundException
     */
    public function getProductById(string $id): Product
    {
        $id = IdValidatorService::validateId($id, 'products');
        $product = Product::query()->find($id);
        if (!$product) {
            throw new ProductNotFoundException($id);
        }
        return $product;
    }

    /**
     * @throws ProductItemNotFoundException
     */
    public function getProductItemById(string $id): ProductItem
    {
        $id = IdValidatorService::validateId($id, 'product_items');
        $productItem = ProductItem::query()->find($id);
        if (!$productItem) {
            throw new ProductItemNotFoundException($id);
        }
        return $productItem;
    }

    public function getProductItemName(ProductItem $item): string
    {
        return $item->name;
    }

    /**
     * @throws ProductNotFoundException
     * @throws ProductItemNotFoundException
     */
    public function getProductItemByCartItem(CartItem $cartItem): ProductItem
    {
       $productItemId = $cartItem->product_item_id;

       return $this->getProductItemById($productItemId);
    }


    /**
     * @throws ProductItemNotFoundException
     * @throws ProductNotFoundInCartException
     * @throws ProductNotFoundException
     * @throws ValidationException
     */
    public function getProductItemIdByCartItemId(Cart $cart, string $id): int
    {
        $cartItem = $this->cartItemRepository->getCartItemById($cart ,$id);
        $productItem = $this->getProductItemByCartItem($cartItem);
        return $productItem->id;
    }

}
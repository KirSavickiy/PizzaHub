<?php

namespace App\Repositories\Product;

use App\Exceptions\Product\ProductItemNotFoundException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductItem;
use App\Services\Validators\IdValidatorService;
use Illuminate\Validation\ValidationException;

class ProductRepository implements ProductRepositoryInterface
{

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
     */
    public function getProductItemByCartItem(CartItem $cartItem): ProductItem
    {
       $productItemId = $cartItem->product_item_id;

       return $this->getProductItemById($productItemId);

    }

}
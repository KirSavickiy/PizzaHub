<?php

namespace App\Actions\Admin\Product;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;

class DeleteProductItemAction
{
    public function __construct(protected ProductRepositoryInterface $productRepository) {}

    public function handle(string $id): JsonResponse
    {
        $productItem = $this->productRepository->getProductItemById($id);

        $productItem->delete();

        return response()->json([
            'success' => true,
            'message' => "Product Item deleted successfully",
            'code' => 200,
        ]);

    }
}
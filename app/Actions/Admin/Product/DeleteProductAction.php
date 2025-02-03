<?php

namespace App\Actions\Admin\Product;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;

class DeleteProductAction
{
    public function __construct(protected ProductRepositoryInterface $productRepository) {}
    public function handle(string $id): JsonResponse
    {

        $product = $this->productRepository->getProductById($id);

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
            'code' => 200,
        ]);

    }
}
<?php

namespace App\Actions\Admin\Product;
use App\Exceptions\Product\ProductCreationException;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;


class UpdateProductAction
{
    public function __construct(protected ProductRepositoryInterface $productRepository) {}
    /**
     * @throws ProductCreationException
     */
    public function handle(array $data, string $id): JsonResponse
    {
        $product = $this->productRepository->getProductById($id);

        try{
            $product->update($data);
        }catch (\Exception $e){
            throw new ProductCreationException("Failed to update Product" . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'code' => 200,
        ]);

    }
}
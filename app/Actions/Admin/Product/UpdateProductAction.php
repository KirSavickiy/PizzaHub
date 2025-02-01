<?php

namespace App\Actions\Admin\Product;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class UpdateProductAction
{
    public function handle(array $data, string $id): JsonResponse
    {
        $product = Product::query()->find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'code' => 404,
            ]);
        }
        $product->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'code' => 200,
        ]);

    }
}
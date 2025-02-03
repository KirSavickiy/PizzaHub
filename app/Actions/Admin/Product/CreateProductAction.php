<?php

namespace App\Actions\Admin\Product;

use App\Exceptions\Product\ProductCreationException;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateProductAction
{
    /**
     * @throws ProductCreationException
     */
    public function handle(array $data): JsonResponse
    {
        DB::beginTransaction();
        try{
            $product = Product::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'category_id' => $data['category_id'],
                'image_path' => $data['image_path'] ?? null,
            ]);

            if (!empty($data['items'])) {
                foreach ($data['items'] as $item) {
                    ProductItem::create([
                        'product_id' => $product->id,
                        'price' => $item['price'],
                        'stock' => $item['stock'],
                        'size' => $item['size'] ?? null,
                        'dough_type' => $item['dough_type'] ?? null,
                    ]);
                }
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'data' => new ProductResource($product->load('items')),
                'message' => 'New product created.',
            ], 201);
        }catch (\Exception $e){
            DB::rollBack();
            throw new ProductCreationException("Failed to create Product " . $e->getMessage());
        }
    }
}
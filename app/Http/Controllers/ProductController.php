<?php

namespace App\Http\Controllers;

use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()->with('items')->paginate(15);
        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'pagination' => [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
        ],
            'message' => 'Products retrieved successfully',
        ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::query()->with('items')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
            'message' => 'Product retrieved successfully',
        ], 200);
    }
}

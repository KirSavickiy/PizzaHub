<?php

namespace App\Http\Controllers;

use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Products\ProductResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()->get();
        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($categories),
            'message' => 'Products retrieved successfully',
        ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $category = Category::query()->with('products')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
            'products' => ProductResource::collection($category->products),
            'message' => 'Product retrieved successfully',
        ], 200);
    }
}

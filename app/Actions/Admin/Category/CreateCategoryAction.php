<?php

namespace App\Actions\Admin\Category;

use App\Exceptions\General\CreationException;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CreateCategoryAction
{
    /**
     * @throws CreationException
     */
    public function handle(array $data): JsonResponse
    {
        try {
            $category = Category::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);
        }catch (\Exception $e){
            throw new CreationException($e->getMessage());
        }

        return response()->json([
            'success' => true,
            'data' => new CategoryResource($category),
            'message' => 'New product created.',
        ], 201);
    }
}
<?php

namespace App\Actions\Admin\Category;

use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;

class DeleteCategoryAction
{
    public function __construct(protected CategoryRepositoryInterface $categoryRepository) {}

    public function handle(string $id): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryById($id);

        if (!$category->deleteWithCheck()){
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete category because it is associated with products.',
                'code' => 400,
            ]);
        };

        return response()->json([
            'success' => true,
            'message' => "Category deleted successfully",
            'code' => 200,
        ]);

    }
}
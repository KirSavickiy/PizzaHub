<?php

namespace App\Actions\Admin\Category;

use App\Exceptions\General\CreationException;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UpdateCategoryAction
{
    public function __construct(protected CategoryRepositoryInterface $categoryRepository) {}

    /**
     * @throws CreationException
     */
    public function handle(array $data, string $id): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryById($id);

        try{
            $category->update($data);
        }catch (\Exception $e){
            throw new CreationException($e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'code' => 200,
        ]);
    }
}
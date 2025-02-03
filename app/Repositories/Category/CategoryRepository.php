<?php

namespace App\Repositories\Category;

use App\Exceptions\Category\CategoryNotFoundException;
use App\Models\Category;
use App\Services\Validators\IdValidatorService;
use Illuminate\Validation\ValidationException;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @throws ValidationException
     * @throws CategoryNotFoundException
     */
    public function getCategoryById(string $id): Category
    {
        $id = IdValidatorService::validateId($id, 'categories');
        $category = Category::query()->find($id);
        if (!$category) {
            throw new CategoryNotFoundException($id);
        }
        return $category;
    }
}
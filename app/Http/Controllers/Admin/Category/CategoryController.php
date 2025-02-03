<?php

namespace App\Http\Controllers\Admin\Category;

use App\Actions\Admin\Category\CreateCategoryAction;
use App\Actions\Admin\Category\DeleteCategoryAction;
use App\Actions\Admin\Category\UpdateCategoryAction;
use App\Exceptions\General\CreationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    /**
     * Store a newly created resource in storage.
     * @throws CreationException
     */
    public function store(CategoryRequest $request, CreateCategoryAction $action): JsonResponse
    {
        return $action->handle($request->validated());
    }


    /**
     * Update the specified resource in storage.
     * @throws CreationException
     */
    public function update(CategoryRequest $request, UpdateCategoryAction $action, string $id): JsonResponse
    {
        return $action->handle($request->validated(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCategoryAction $action, string $id): JsonResponse
    {
        return $action->handle($id);
    }

}

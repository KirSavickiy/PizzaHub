<?php

namespace App\Http\Controllers\Admin\Product;

use App\Actions\Admin\Product\CreateProductAction;
use App\Actions\Admin\Product\DeleteProductAction;
use App\Actions\Admin\Product\DeleteProductItemAction;
use App\Actions\Admin\Product\UpdateProductAction;
use App\Actions\Admin\Product\UpdateProductItemAction;
use App\Exceptions\Product\ProductCreationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductItemRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * @throws ProductCreationException
     */
    public function store(CreateProductRequest $request, CreateProductAction $action): JsonResponse
    {
        return $action->handle($request->validated());
    }

    /**
     * @throws ProductCreationException
     */
    public function update(UpdateProductRequest $request, UpdateProductAction $action, string $id): JsonResponse
    {
        return $action->handle($request->validated(), $id);
    }

    /**
     * @throws ProductCreationException
     */
    public function updateItem(UpdateProductItemRequest $request, UpdateProductItemAction $action, string $id): JsonResponse
    {
        return $action->handle($request->validated(), $id);
    }

    public function destroy(DeleteProductAction $action, string $id): JsonResponse
    {
        return $action->handle($id);
    }

    public function destroyItem(DeleteProductItemAction $action, string $id): JsonResponse
    {
        return $action->handle($id);
    }
}

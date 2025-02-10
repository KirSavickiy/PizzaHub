<?php

namespace App\Http\Controllers\Admin\Product;

use App\Actions\Admin\Product\DeleteProductItemAction;
use App\Actions\Admin\Product\UpdateProductItemAction;
use App\Exceptions\Product\ProductCreationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UpdateProductItemRequest;
use Illuminate\Http\JsonResponse;

class ProductItemController extends Controller
{
    /**
     * @throws ProductCreationException
     */
    public function update(UpdateProductItemRequest $request, UpdateProductItemAction $action, string $id): JsonResponse
    {
        return $action->handle($request->validated(), $id);
    }
    public function destroy(DeleteProductItemAction $action, string $id): JsonResponse
    {
        return $action->handle($id);
    }
}

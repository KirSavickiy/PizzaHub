<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Product\CreateProductAction;
use App\Actions\Admin\Product\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function store(CreateProductRequest $request, CreateProductAction $action): JsonResponse
    {
        return $action->handle($request->validated());
    }

    public function update(UpdateProductRequest $request, UpdateProductAction $action, string $id): JsonResponse
    {
        return $action->handle($request->validated(), $id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Actions\Cart\AddToCartAction;
use App\Actions\Cart\CreateCartAction;
use App\Actions\Cart\GetCartAction;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\GetCartRequest;
use App\Http\Requests\Cart\CreateCartRequest;
use Illuminate\Http\JsonResponse;



class CartController extends Controller
{
    public function getCart(GetCartAction $action, GetCartRequest $request): JsonResponse
    {
        return $action->handle($request);
    }

    public function addToCart(AddToCartAction $action, AddToCartRequest $request): JsonResponse
    {
        return $action->handle($request);
    }

    public function createCart(CreateCartAction $action, CreateCartRequest $request): JsonResponse
    {
        return $action->handle($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Actions\Cart\AddToCartAction;
use App\Actions\Cart\CreateCartAction;
use App\Actions\Cart\GetCartAction;
use App\Actions\Cart\RemoveItemCartAction;
use App\Actions\Cart\UpdateCartAction;
use App\Exceptions\Cart\CartNotFoundException;
use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\GetCartRequest;
use App\Http\Requests\Cart\CreateCartRequest;
use App\Http\Requests\Cart\RemoveItemCartRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\CartItem;
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

    public function updateItem(UpdateCartAction $action, UpdateCartItemRequest $request): JsonResponse
    {
        return $action->handle($request);
    }

    /**
     * @throws ProductNotFoundInCartException
     * @throws CartNotFoundException
     */
    public function removeItem(RemoveItemCartAction $action, RemoveItemCartRequest $request): JsonResponse
    {
        return $action->handle($request);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Actions\User\Cart\AddToCartAction;
use App\Actions\User\Cart\CreateCartAction;
use App\Actions\User\Cart\GetCartAction;
use App\Actions\User\Cart\RemoveItemCartAction;
use App\Actions\User\Cart\UpdateCartAction;
use App\Exceptions\Cart\CartNotFoundException;
use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Cart\AddToCartRequest;
use App\Http\Requests\User\Cart\CreateCartRequest;
use App\Http\Requests\User\Cart\GetCartRequest;
use App\Http\Requests\User\Cart\RemoveItemCartRequest;
use App\Http\Requests\User\Cart\UpdateCartItemRequest;
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

    /**
     * @throws ProductNotFoundInCartException
     * @throws CartNotFoundException
     */
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

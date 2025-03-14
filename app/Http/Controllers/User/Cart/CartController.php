<?php

namespace App\Http\Controllers\User\Cart;

use App\Actions\User\Cart\AddToCartAction;
use App\Actions\User\Cart\CreateCartAction;
use App\Actions\User\Cart\DeleteItemCartAction;
use App\Actions\User\Cart\GetCartAction;
use App\Actions\User\Cart\UpdateCartAction;
use App\Exceptions\Cart\CartNotFoundException;
use App\Exceptions\Cart\ProductNotFoundInCartException;
use App\Exceptions\Product\ProductOutOfLimitsException;
use App\Exceptions\Product\ProductOutOfStockException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Cart\AddToCartRequest;
use App\Http\Requests\User\Cart\GetCartRequest;
use App\Http\Requests\User\Cart\RemoveItemCartRequest;
use App\Http\Requests\User\Cart\UpdateCartItemRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;


class CartController extends Controller
{
    use AuthorizesRequests;
    public function getCart(GetCartAction $action, GetCartRequest $request): JsonResponse
    {
        return $action->handle($request);
    }

    public function addToCart(AddToCartAction $action, AddToCartRequest $request): JsonResponse
    {
        return $action->handle($request);
    }

    public function createCart(CreateCartAction $action): JsonResponse
    {
        return $action->handle();
    }

    /**
     * @throws AuthorizationException
     * @throws ProductNotFoundInCartException
     * @throws ProductOutOfStockException
     * @throws ProductOutOfLimitsException
     * @throws CartNotFoundException
     */
    public function updateItem(UpdateCartAction $action, UpdateCartItemRequest $request, string $id): JsonResponse
    {
        $cartId = $request->query('cart-id') ?? null;
        return $action->handle($request->validated(), $cartId, $id);
    }

    /**
     * @throws CartNotFoundException
     * @throws AuthorizationException
     */
    public function removeItem(DeleteItemCartAction $action, RemoveItemCartRequest $request, string $id): JsonResponse
    {
        $cartId = $request->query('cart-id') ?? null;
        return $action->handle($cartId, $id);
    }
}

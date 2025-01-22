<?php

namespace App\Http\Controllers;

use App\Actions\Cart\AddToCartAction;
use App\Http\Requests\CartRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Actions\Cart\GetCartAction;


class CartController extends Controller
{
    public function index(GetCartAction $action, Request $request): JsonResponse
    {
        return $action->handle($request);
    }

    public function store(AddToCartAction $action, CartRequest $request): JsonResponse
    {
        return $action->handle($request);
    }
}

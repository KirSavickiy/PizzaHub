<?php

namespace App\Actions\Cart;

use App\Services\Auth\AuthCheckService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\Cart\CartServiceInterface;

class GetCart
{
    protected AuthCheckService $authCheckService;
    protected CartServiceInterface $cartService;
    public function __construct(AuthCheckService $authCheckService, CartServiceInterface $cartService)
    {
        $this->authCheckService = $authCheckService;
        $this->cartService = $cartService;
    }

    public function handle(): JsonResponse
    {
        $cart = $this->cartService->getCart();
        return response()->json($cart);
    }


}
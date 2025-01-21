<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Actions\Cart\GetCart;


class CartController extends Controller
{
    public function index(GetCart $action): JsonResponse
    {
        return $action->handle();
    }
}

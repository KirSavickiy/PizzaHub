<?php

namespace App\Http\Controllers\User\Order;

use App\Actions\User\Order\CreateOrderAction;
use App\Actions\User\Order\GetOrderByIdAction;
use App\Actions\User\Order\GetOrdersAction;
use App\Exceptions\Order\GetOrdersException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Order\CreateOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws GetOrdersException
     */
    public function index(GetOrdersAction $action): JsonResponse
    {
        return $action->handle();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request, CreateOrderAction $action): JsonResponse
    {
        return $action->handle($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, GetOrderByIdAction $action): JsonResponse
    {
        return $action->handle($id);
    }
}

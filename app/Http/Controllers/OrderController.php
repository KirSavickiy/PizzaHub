<?php

namespace App\Http\Controllers;

use App\Actions\Address\CreateAddressAction;
use App\Actions\Order\CreateOrderAction;
use App\Actions\Order\GetOrderByIdAction;
use App\Actions\Order\GetOrdersAction;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetOrdersAction $action)
    {
        return $action->handle();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request, CreateOrderAction $action)
    {
        return $action->handle($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, GetOrderByIdAction $action)
    {
        return $action->handle($id);
    }
}

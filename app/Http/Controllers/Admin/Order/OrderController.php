<?php

namespace App\Http\Controllers\Admin\Order;

use App\Actions\Admin\Order\ChangeStatusAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\ChangeStatusOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    public function changeStatus(ChangeStatusAction $action, ChangeStatusOrderRequest $request, string $id) :JsonResponse
    {
        return $action->handle($request->validated(), $id);
    }
}

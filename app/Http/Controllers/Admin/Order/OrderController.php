<?php

namespace App\Http\Controllers\Admin\Order;

use App\Actions\Admin\Order\ChangeStatusAction;
use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\General\CreationException;
use App\Exceptions\Order\GetOrdersException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\ChangeStatusOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * @throws CreationException
     * @throws GetOrdersException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function changeStatus(ChangeStatusAction $action, ChangeStatusOrderRequest $request, string $id) :JsonResponse
    {
        return $action->handle($request->validated(), $id);
    }
}

<?php

namespace App\Http\Controllers\User\Address;

use App\Actions\User\Address\CreateAddressAction;
use App\Actions\User\Address\DeleteAddressAction;
use App\Actions\User\Address\GetAddressByIdAction;
use App\Actions\User\Address\GetAddressesAction;
use App\Actions\User\Address\UpdateAddressAction;
use App\Exceptions\Address\AddressException;
use App\Exceptions\Address\GetAddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Address\AddressRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{

    /**
     * @throws AuthenticationException
     * @throws GetAddressException
     */
    public function index(GetAddressesAction $action): JsonResponse
    {
        return $action->handle();
    }

    /**
     * Store a newly created resource in storage.
     * @throws AddressException
     * @throws AuthenticationException
     */
    public function store(CreateAddressAction $action, AddressRequest $request): JsonResponse
    {
        return $action->handle($request->validated());
    }


    /**
     * @throws AuthenticationException
     * @throws ValidationException
     * @throws GetAddressException
     */
    public function show(string $id, GetAddressByIdAction $action): JsonResponse
    {
        return $action->handle($id);
    }

    /**
     * @throws AddressException
     * @throws AuthenticationException
     * @throws GetAddressException
     * @throws ValidationException
     */
    public function update(string $id, AddressRequest $request, UpdateAddressAction $action): JsonResponse
    {
        return $action->handle($id, $request->validated());
    }

    /**
     * @throws AuthenticationException
     * @throws ValidationException
     * @throws GetAddressException
     */
    public function destroy(string $id, DeleteAddressAction $action): JsonResponse
    {
        return $action->handle($id);
    }
}

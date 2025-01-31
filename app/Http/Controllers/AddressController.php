<?php

namespace App\Http\Controllers;

use App\Actions\Address\CreateAddressAction;
use App\Actions\Address\DeleteAddressAction;
use App\Actions\Address\GetAddressesAction;
use App\Actions\Address\GetAddressByIdAction;
use App\Actions\Address\UpdateAddressAction;
use App\Exceptions\Address\AddressCreationException;
use App\Exceptions\Address\GetAddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Http\Requests\Address\AddressRequest;
use Illuminate\Http\JsonResponse;
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
     * @throws AddressCreationException
     * @throws AuthenticationException
     */
    public function store(CreateAddressAction $action, AddressRequest $request): JsonResponse
    {
        return $action->handle($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, GetAddressByIdAction $action): JsonResponse
    {
        return $action->handle($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, AddressRequest $request, UpdateAddressAction $action): JsonResponse
    {
        return $action->handle($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, DeleteAddressAction $action): JsonResponse
    {
        return $action->handle($id);
    }
}

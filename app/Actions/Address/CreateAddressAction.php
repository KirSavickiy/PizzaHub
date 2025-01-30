<?php

namespace App\Actions\Address;

use App\Exceptions\Address\AddressCreationException;
use App\Exceptions\Auth\AuthenticationException;
use App\Http\Resources\Addresses\AddressResource;
use App\Services\Address\AddressService;
use Illuminate\Http\JsonResponse;

class CreateAddressAction
{
    protected AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * @throws AddressCreationException
     * @throws AuthenticationException
     */
    public function handle(array $data): JsonResponse
    {
        $address = $this->addressService->create($data);

        return response()->json([
            'success' => true,
            'data' => new AddressResource($address),
            'message' => 'New address created.',
        ], 201);
    }
}
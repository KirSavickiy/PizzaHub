<?php

namespace App\Actions\User\Address;

use App\Exceptions\Address\AddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Http\Resources\Address\AddressResource;
use App\Services\Address\AddressService;
use Illuminate\Http\JsonResponse;

class CreateAddressAction
{
    public function __construct(protected AddressService $addressService) {}

    /**
     * @throws AddressException
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
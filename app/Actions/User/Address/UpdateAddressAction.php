<?php

namespace App\Actions\User\Address;

use App\Exceptions\Address\AddressException;
use App\Exceptions\Address\GetAddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Http\Resources\Address\AddressResource;
use App\Services\Address\AddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UpdateAddressAction
{
    public function __construct(protected AddressService $addressService) {}

    /**
     * @throws AuthenticationException
     * @throws GetAddressException
     * @throws ValidationException
     * @throws AddressException
     */
    public function handle(string $id, array $data): JsonResponse
    {
        $address = $this->addressService->update($id, $data);

        return response()->json([
            'success' => true,
            'data' => new AddressResource($address),
            'message' => 'Addresses retrieved successfully',
        ], 200);
    }
}
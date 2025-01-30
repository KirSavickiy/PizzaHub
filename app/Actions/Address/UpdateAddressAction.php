<?php

namespace App\Actions\Address;

use App\Exceptions\Address\GetAddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Http\Resources\Addresses\AddressResource;
use App\Services\Address\AddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UpdateAddressAction
{
    protected AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * @throws AuthenticationException
     * @throws GetAddressException
     */
    public function handle(string $id, array $data): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Address with ID $id not found",
            ], 404);
        }

        $address = $this->addressService->update($id, $data);

        return response()->json([
            'success' => true,
            'data' => new AddressResource($address),
            'message' => 'Addresses retrieved successfully',
        ], 200);
    }
}
<?php

namespace App\Actions\User\Address;

use App\Exceptions\Address\GetAddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Http\Resources\Address\AddressResource;
use App\Services\Address\AddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class DeleteAddressAction
{
    public function __construct(protected AddressService $addressService) {}

    /**
     * @throws AuthenticationException
     * @throws GetAddressException
     * @throws ValidationException
     */
    public function handle(string $id): JsonResponse
    {
        $this->addressService->delete($id);

        $addresses = $this->addressService->getAll();
        return response()->json([
            'success' => true,
            'data' => AddressResource::collection($addresses),
            'message' => "Address with ID $id deleted successfully.",
        ], 200);
    }
}
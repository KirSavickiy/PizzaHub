<?php

namespace App\Actions\Address;

use App\Exceptions\Address\GetAddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Http\Resources\Addresses\AddressResource;
use App\Services\Address\AddressService;
use Illuminate\Http\JsonResponse;

class GetAddressAction
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
    public function handle(): JsonResponse
    {
        $addresses = $this->addressService->getAll();
        return response()->json([
            'success' => true,
            'data' => AddressResource::collection($addresses),
            'message' => 'Addresses retrieved successfully',
        ], 200);
    }

}
<?php

namespace App\Services\Address;

use App\Exceptions\Address\GetAddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Models\Address;
use App\Exceptions\Address\AddressCreationException;
use App\Services\Auth\AuthService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class AddressService
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws GetAddressException
     * @throws AuthenticationException
     */
    public function getById(string $id): Address
    {
        $userId = $this->authService->getAuthenticatedUserId();

        $address = Address::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            throw new GetAddressException("Address with ID {$id} not found", 404);
        }

        return $address;
    }

    /**
     * @throws GetAddressException
     * @throws AuthenticationException
     */
    public function getAll(): Collection
    {
        $userId = $this->authService->getAuthenticatedUserId();
        try {
           return Address::where('user_id', $userId)->get();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new GetAddressException("Failed to retrieve addresses" . $e->getMessage(), 500);
        }
    }

    /**
     * @throws AddressCreationException
     * @throws AuthenticationException
     */
    public function create(array $data): Address
    {
        $userId = $this->authService->getAuthenticatedUserId();
        $data['user_id'] = $userId;

        try {
            return Address::create($data);
        } catch (QueryException $e) {
            throw new AddressCreationException("Database error: " . $e->getMessage(), 500);
        }
    }

    /**
     * @throws AuthenticationException
     * @throws GetAddressException
     */
    public function update(string $id, array $data): Address
    {
        $address = $this->getById($id);
        $address->update($data);
        return $address;
    }
}
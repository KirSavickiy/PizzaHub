<?php

namespace App\Services\Address;

use App\Exceptions\Address\GetAddressException;
use App\Exceptions\Auth\AuthenticationException;
use App\Exceptions\Address\AddressCreationException;
use App\Models\Address;
use App\Services\Auth\AuthService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use App\Services\Validators\IdValidatorService;
use Illuminate\Validation\ValidationException;

class AddressService
{
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * @throws GetAddressException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function getById(string $id): Address
    {
        return $this->findAddressOrFail($id);
    }

    /**
     * @throws GetAddressException
     * @throws AuthenticationException
     */
    public function getAll(): Collection
    {
        try {
            return Address::where('user_id', $this->getUserId())->get();
        } catch (QueryException) {
            throw new GetAddressException("Failed to retrieve addresses", 500);
        }
    }

    /**
     * @throws AddressCreationException
     * @throws AuthenticationException
     */
    public function create(array $data): Address
    {
        $data['user_id'] = $this->getUserId();

        try {
            return Address::create($data);
        } catch (QueryException $e) {
            throw new AddressCreationException("Failed to create address" . $e->getMessage(), 500);
        }
    }

    /**
     * @throws AuthenticationException
     * @throws GetAddressException
     * @throws ValidationException
     */
    public function update(string $id, array $data): Address
    {
        $address = $this->findAddressOrFail($id);
        $address->update($data);

        return $address;
    }

    /**
     * @throws AuthenticationException
     * @throws GetAddressException
     * @throws ValidationException
     */
    public function delete(string $id): void
    {
        $this->findAddressOrFail($id)->delete();
    }

    /**
     * @throws AuthenticationException
     */
    private function getUserId(): int
    {
        return $this->authService->getAuthenticatedUserId();
    }

    /**
     * @throws GetAddressException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    private function findAddressOrFail(string $id): Address
    {
        $id = IdValidatorService::validateId($id, 'addresses');
        $address = Address::where('id', $id)
            ->where('user_id', $this->getUserId())
            ->first();

        if (!$address) {
            throw new GetAddressException("Address with ID $id not found", 404);
        }

        return $address;
    }
}

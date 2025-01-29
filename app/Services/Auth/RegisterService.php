<?php

namespace App\Services\Auth;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    /**
     * Registers a new user
     *
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function register(array $data): User
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'] ?? null,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'birth_date' => $data['birth_date'] ?? null,
                'password' => Hash::make($data['password']),
                'role_id' => User::getUserRoleId(),
            ]);

            DB::commit();
            event(new UserRegistered($user));

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Error while registering the user: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Services\Auth;

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
     */
    public function register(array $data)
    {
        DB::beginTransaction();
        try{
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'] ?? null,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'birth_date' => $data['birth_date'] ?? null,
                'password' => Hash::make($data['password']),
                'role_id' => User::getUserRoleId(),
            ]);
            $user->cart()->create(); /*???*/
            DB::commit();
            return $user;
        } catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
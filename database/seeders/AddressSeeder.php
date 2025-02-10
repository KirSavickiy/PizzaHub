<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $addressCount = rand(1, 3);
            Address::factory()->count($addressCount)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}

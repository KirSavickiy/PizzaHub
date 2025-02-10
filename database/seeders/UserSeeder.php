<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->asUser()->withCart()->create();
        User::factory()->asUser()->withCart()->create(['email' => 'test@user.com', 'password' => bcrypt('password')]);
        User::factory()->asAdmin()->create(['email' => 'test@admin.com', 'password' => bcrypt('password')]);
    }
}

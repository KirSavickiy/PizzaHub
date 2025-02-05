<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date(),
        ];
    }

    public function asUser(): self
    {
        return $this->state(function (array $attributes) {
            $userRole = Role::firstOrCreate(['name' => 'user']);
            return ['role_id' => $userRole->id];
        });
    }

    public function asAdmin(): self
    {
        return $this->state(function (array $attributes) {
            $adminRole = Role::firstOrCreate(['name' => 'admin']);
            return ['role_id' => $adminRole->id];
        });
    }

    /**
     * Create a cart for the user after they are created.
     */
    public function withCart(): self
    {
        return $this->afterCreating(function ($user) {
            $user->cart()->create();
        });
    }

}

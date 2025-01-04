<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['admin', 'user']),
        ];
    }

    public function user()
    {
        return $this->state(fn () => ['name' => 'user']);
    }

    public function admin()
    {
        return $this->state(fn () => ['name' => 'admin']);
    }
}

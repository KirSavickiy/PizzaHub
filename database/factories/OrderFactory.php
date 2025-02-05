<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'delivery_method' => $this->faker->randomElement(['pickup', 'delivery']),
            'payment_method' => $this->faker->randomElement(['cash', 'card', 'online']),
            'delivery_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'total_price' => $this->faker->randomFloat(2, 100, 1000),
            'address_id' => Address::factory(),
        ];
    }

}

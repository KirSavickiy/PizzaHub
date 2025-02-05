<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderStatusHistory>
 */
class OrderStatusHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'old_status' => 'new',
            'new_status' => $this->faker->randomElement(['new', 'processed', 'shipped', 'delivered', 'canceled']),
            'comment' => $this->faker->optional()->text(),
            'changed_by' => User::factory(),
            'changed_at' => $this->faker->dateTimeThisYear()->format('Y-m-d'),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
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
                'product_item_id' => ProductItem::factory(),
                'quantity' => $this->faker->numberBetween(1, 10),
                'price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}

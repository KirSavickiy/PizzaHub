<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductItem>
 */
class ProductItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'product_id' => Product::pluck('id')->random(),
        ];
    }

    public function pizzas(): static
    {
        return $this->state(fn () => [
            'size'=> $this->faker->randomElement([20, 30, 35]),
            'dough_type' => $this->faker->randomElement(['Тонкое', 'Традиционное']),
        ]);
    }

}

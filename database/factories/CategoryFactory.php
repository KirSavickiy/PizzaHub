<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Новинки', 'Сытные пиццы', 'Пиццы', 'Комбо', 'Закуски', 'Завтраки',
            'Коктейли', 'Кофе', 'Напитки', 'Десерты', 'Соусы', 'Хиты',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'description' => $this->faker->text(100),
        ];
    }
}

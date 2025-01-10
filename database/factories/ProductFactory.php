<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'image_path' => $this->faker->imageUrl(),
            'category_id' => Category::pluck('id')->random(),
        ];
    }
    public function pizzas(): static
    {
        return $this->state(fn () => [
            'name'=> $this->faker->unique()->randomElement([
                'Pepsi', 'Mirinda', '7UP', 'Морс Вишня', 'Морс Клюква', 'Морс Черная смородина',
                'Квас Хлебный 1 л.', 'Квас Темный 1 л.', 'Aqua Minerale газ. 0,5 л.', 'Aqua Minerale негаз. 0,5 л.',
            ]),
        ]);
    }

    public function drinks(): static
    {
        return $this->state(fn () => [
            'name'=> $this->faker->unique()->randomElement([
                'Пицца из половинок', 'Кола-барбекю', 'Бефстроганов', 'Баварская',
                'Жюльен', 'Карбонара', 'Кантри-пицца', 'Аррива!', 'Чикен бомбони',
                'Охотничья', 'Креветки со сладким чили', 'Мясная с аджикой',
                'Ветчина и огурчики', 'Сырная', 'Чоризо фреш', 'Деревенская',
                'Ветчина и сыр', 'Песто', 'Итальянский цыпленок', 'Двойной цыпленок',
                'Додо микс', 'Мясная', 'Бургер-пицца', 'Домашняя', 'Пепперони',
            ]),
        ]);
    }

}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductItem;
use Illuminate\Database\Seeder;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::whereIn('name', ['Пиццы', 'Напитки'])->pluck('id', 'name');

        $pizzas = Product::factory(10)->pizzas()->create(['category_id' => $categories['Пиццы']]);
        $drinks = Product::factory(10)->drinks()->create(['category_id' => $categories['Напитки']]);

        $pizzas->each(function ($pizza) {
            ProductItem::factory()->pizzas()->create(['product_id' => $pizza->id]);
        });

        $drinks->each(function ($drink) {
            ProductItem::factory()->create(['product_id' => $drink->id]);
        });
    }
}
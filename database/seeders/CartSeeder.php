<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductItem;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specificCart = Cart::factory()->create(['user_id' => null, 'session_id' => 'b4ab6310-1a3e-43d9-b09f-6587bf70a037']);
        $carts = Cart::factory()->count(20)->create(['user_id' => null]);

        $allCarts = $carts->push($specificCart);
        $productItems = ProductItem::all();

        foreach ($allCarts as $cart) {
            CartItem::factory()->count(random_int(1, 5))->create([
                'cart_id' => $cart->id,
                'product_item_id' => $productItems->random()->id,
                'price' => $productItems->random()->price,
            ]);
        }
    }
}

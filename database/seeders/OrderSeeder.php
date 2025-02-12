<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\ProductItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        $users = User::all();
        $addresses = Address::all();
        $productItems = ProductItem::all();

        if ($users->isEmpty()) {
            $users = User::factory()->count(10)->create();
        }

        if ($addresses->isEmpty()) {
            $addresses = Address::factory()->count(2)->create([
                'user_id' => $users->random()->id,
            ]);
        }

        if ($productItems->isEmpty()) {
            $productItems = ProductItem::factory()->count(50)->create();
        }

        foreach ($users as $user) {
            Order::factory()->count(rand(1,4))->create([
                'user_id' => $user->id,
                'delivery_method' => 'delivery',
                'address_id' => $user->addresses->random()->id,]);
        }

        $orders = Order::all();

        foreach ($orders as $order) {
            $orderItems = OrderItem::factory()->count(random_int(1, 5))->create([
                'order_id' => $order->id,
                'product_item_id' => $productItems->random()->id,
                'price' => fn () => $productItems->random()->price,
            ]);

            OrderStatusHistory::factory()->create([
                'order_id' => $order->id,
                'changed_by' => $order->user_id,
                'old_status' => 'new',
                'new_status' => 'processed',
            ]);
        }
    }
}

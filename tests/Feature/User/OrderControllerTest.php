<?php

namespace Tests\Feature\User;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;


class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Order $order;
    private OrderItem $orderItem;

    private Address $address;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->asUser()->withCart()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $productItem = ProductItem::factory()->create(['product_id' => $product->id]);

        $this->address = Address::factory()->create(['user_id' => $this->user->id]);

        $cartItem = CartItem::factory()->create([
            'cart_id' => $this->user->cart->id,
            'product_item_id' => $productItem->id,
            'quantity' => 2,
            'price' => $productItem->price,
        ]);

        $this->order = Order::factory()->create([
            'user_id' => $this->user->id,
            'delivery_method' => 'pickup',
            'payment_method' => 'cash',
            'delivery_time' => now()->addDays(2),
            'total_price' => $cartItem->price * $cartItem->quantity,
            'address_id' => null,
        ]);


        $this->orderItem = OrderItem::factory()->create([
            'order_id' => $this->order->id,
            'product_item_id' => $productItem->id,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->price,
        ]);


        OrderStatusHistory::factory()->create([
            'order_id' => $this->order->id,
            'old_status' => 'new',
            'new_status' => 'new',
            'changed_by' => $this->user->id,
            'changed_at' => now(),
        ]);

    }

    public function test_can_retrieve_order_for_authenticated_user(): void
    {
        $this->actingAs($this->user);
        $response = $this->get('/api/orders');
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment([
            'id' => $this->order->id,
            'user_id' => $this->user->id,
            'status' => $this->order->statuses->first()->new_status,
            'delivery_method' => $this->order->delivery_method,
            'payment_method' => $this->order->payment_method,
        ]);
    }

    public function test_cannot_retrieve_order_for_unauthenticated_user(): void
    {
        $response = $this->get('/api/orders');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_can_retrieve_order_by_id_for_authenticated_user(): void
    {
        $this->actingAs($this->user);
        $response = $this->get('/api/orders/'.$this->order->id);
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment([
            'id' => $this->order->id,
            'user_id' => $this->user->id,
            'status' => $this->order->statuses->first()->new_status,
            'delivery_method' => $this->order->delivery_method,
            'payment_method' => $this->order->payment_method,
        ]);
    }

    public function test_can_retrieve_order_by_id_for_unauthenticated_user(): void
    {
        $response = $this->get('/api/orders/'.$this->order->id);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_can_create_order_for_authenticated_user(): void
    {
        $orderData = [
            'delivery_method' => 'delivery',
            'payment_method' => 'card',
            'delivery_time' => '2025-02-04 15:30:45',
            'address_id' => $this->address->id,
        ];

        $this->actingAs($this->user);
        $response = $this->post('/api/orders', $orderData);
        $response->assertStatus(Response::HTTP_CREATED);

        $orderId = $response->json('data.id');
        $order = Order::find($orderId);

        $this->assertNotNull($order, 'Заказ не был создан в базе данных');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $this->user->id,
            'delivery_method' => 'delivery',
            'payment_method' => 'card',
            'delivery_time' => '2025-02-04 15:30:45',
            'address_id' => $this->address->id,
        ]);

        foreach ($this->user->cart->items as $cartItem) {
            $this->assertDatabaseHas('order_items', [
                'order_id' => $order->id,
                'product_item_id' => $cartItem->product_item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
            ]);
        }

        $this->assertDatabaseMissing('cart_items', ['cart_id' => $this->user->cart->id]);
    }

    public function test_cannot_create_order_for_unauthenticated_user(): void
    {
        $orderData = [
            'delivery_method' => 'delivery',
            'payment_method' => 'card',
            'delivery_time' => '2025-02-04 15:30:45',
            'address_id' => $this->address->id,
        ];

        $response = $this->post('/api/orders', $orderData);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}


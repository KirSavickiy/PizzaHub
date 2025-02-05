<?php

namespace Tests\Feature;

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
use Tests\TestCase;
use Illuminate\Http\Response;


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

    public function testCanRetrieveOrderForAuthenticatedUser(): void
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

    public function testCannotRetrieveOrderForUnauthenticatedUser(): void
    {
        $response = $this->get('/api/orders');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanRetrieveOrderByIdForAuthenticatedUser(): void
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

    public function testCanRetrieveOrderByIdForUnauthenticatedUser(): void
    {
        $response = $this->get('/api/orders/'.$this->order->id);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanCreateOrderForAuthenticatedUser(): void
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
    }

    public function testCannotCreateOrderForUnauthenticatedUser(): void
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

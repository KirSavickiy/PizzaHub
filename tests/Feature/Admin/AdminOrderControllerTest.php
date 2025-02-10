<?php

namespace Tests\Feature\Admin;

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

class AdminOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Order $order;
    private OrderItem $orderItem;

    private Address $address;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->asAdmin()->create();
        $client = User::factory()->asUser()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $productItem = ProductItem::factory()->create(['product_id' => $product->id]);

        $this->order = Order::factory()->create([
            'user_id' => $client->id,
            'delivery_method' => 'pickup',
            'payment_method' => 'cash',
            'delivery_time' => now()->addDays(2),
            'total_price' => $productItem->price * 1,
            'address_id' => null,
        ]);


        $this->orderItem = OrderItem::factory()->create([
            'order_id' => $this->order->id,
            'product_item_id' => $productItem->id,
            'quantity' => 1,
            'price' => $productItem->price,
        ]);

        OrderStatusHistory::factory()->create([
            'order_id' => $this->order->id,
            'old_status' => 'new',
            'new_status' => 'new',
            'changed_by' => $client->id,
            'changed_at' => now(),
        ]);
    }

    public function test_admin_can_get_orders_list(): void
    {
        $this->actingAs($this->admin);
        $response = $this->get('/api/admin/orders');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_admin_cannot_get_orders_list_unauthorized():void
    {
        $response = $this->get('/api/admin/orders');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_admin_can_view_order():void
    {
        $this->actingAs($this->admin);
        $response = $this->get('/api/admin/orders/' . $this->order->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_non_admin_cannot_view_order():void
    {
        $this->actingAs($this->admin);
        $response = $this->get('/api/admin/orders/99999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_admin_can_update_order_status():void
    {
        $this->actingAs($this->admin);
        $data = [
            'status' => 'in progress',
            'comment' => 'test comment',
        ];
        $response = $this->post('/api/admin/orders/' . $this->order->id . '/status', $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_non_admin_cannot_update_order_status():void
    {
        $data = [
            'status' => 'in progress',
            'comment' => 'test comment',
        ];
        $response = $this->post('/api/admin/orders/' . $this->order->id . '/status', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}

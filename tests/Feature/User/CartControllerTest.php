<?php

namespace Tests\Feature\User;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private ProductItem $productItem;
    private Cart $cart;
    private CartItem $cartItem;
    private CartItem $cartGuestItem;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->asUser()->withCart()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $this->productItem = ProductItem::factory()->create(['product_id' => $product->id, 'stock' => 100]);
        $this->cart = Cart::factory()->create(['user_id' => null]);

        $this->cartItem = CartItem::factory()->create([
            'cart_id' => $this->user->cart->id,
            'product_item_id' => $this->productItem->id,
            'quantity' => 2,
            'price' => $this->productItem->price,
        ]);

        $this->cartGuestItem = CartItem::factory()->create([
            'cart_id' => $this->cart->id,
            'product_item_id' => $this->productItem->id,
            'quantity' => 2,
            'price' => $this->productItem->price,
        ]);
    }

    public function test_can_retrieve_cart_for_authenticated_user(): void
    {
        $this->actingAs($this->user);
        $response = $this->get('/api/cart');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_retrieve_cart_for_unauthenticated_user_without_cart_id(): void
    {
        $response = $this->get('/api/cart');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_can_create_cart_for_unauthenticated_user(): void
    {
        $response = $this->post('/api/cart');
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_can_retrieve_cart_for_unauthenticated_user_with_cart_id():void
    {
        $response = $this->get('/api/cart/?cart-id=' . $this->cart->session_id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_add_product_to_cart_for_authenticated_user():void
    {
        $this->actingAs($this->user);
        $cartData = [
            'product_item_id' => $this->productItem->id,
        ];
        $response = $this->post('/api/cart/add', $cartData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_add_product_to_cart_for_unauthenticated_user_without_cart_id():void
    {
        $cartData = [
            'product_item_id' => $this->productItem->id,
        ];


        $response = $this->post('/api/cart/add', $cartData);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_add_product_to_cart_for_unauthenticated_user_with_cart_id():void
    {
        $cartData = [
            'product_item_id' => $this->productItem->id,
        ];
        $response = $this->post('/api/cart/add/?cart-id='. $this->cart->session_id , $cartData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_create_cart_for_authenticated_user(): void
    {
        $this->actingAs($this->user);
        $response = $this->post('/api/cart');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(["message" => "Cart already exists."]);
    }

    public function test_can_remove_product_from_cart_for_authenticated_user():void
    {
        $this->actingAs($this->user);
        $response = $this->delete('/api/cart/remove/'. $this->cartItem->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_remove_product_from_cart_for_unauthenticated_user_without_cart_id():void
    {
        $response = $this->delete('/api/cart/remove/'. $this->cartItem->id);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_can_remove_product_from_cart_for_unauthenticated_user_with_cart_id():void
    {
        $response = $this->delete('/api/cart/remove/' . $this->cartGuestItem->id . '?cart-id='. $this->cart->session_id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_update_product_in_cart_for_authenticated_user():void
    {
        $cartData = [
            'quantity' => rand(1, 10),
        ];
        $this->actingAs($this->user);
        $response = $this->put('/api/cart/update/'. $this->cartItem->id, $cartData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_update_product_in_cart_for_authenticated_user_with_wrong_data():void
    {
        $cartData = [
            'wrong' => rand(1, 10),
        ];
        $this->actingAs($this->user);
        $response = $this->put('/api/cart/update/'. $this->cartItem->id, $cartData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_cannot_update_product_in_cart_for_authenticated_user_with_wrong_id():void
    {
        $cartData = [
            'quantity' => rand(1, 5),
        ];
        $this->actingAs($this->user);
        $response = $this->put('/api/cart/update/'. '99999', $cartData);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_cannot_update_product_in_cart_for_unauthenticated_user_without_cart_id():void
    {
        $cartData = [
            'quantity' => rand(1, 5),
        ];
        $response = $this->put('/api/cart/update/'. $this->cartItem->id, $cartData);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_can_update_product_in_cart_for_authenticated_user_with_cart_id():void
    {
        $cartData = [
            'quantity' => rand(1, 5),
        ];
        $response = $this->put('/api/cart/update/'. $this->cartGuestItem->id . '?cart-id='. $this->cart->session_id, $cartData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_update_product_in_cart_for_unauthenticated_user_with_wrong_cart_id():void
    {
        $cartData = [
            'quantity' => rand(1, 10),
        ];
        $response = $this->put('/api/cart/update/'. $this->cartGuestItem->id . '?cart-id='. (string) Str::uuid(), $cartData);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

}

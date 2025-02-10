<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AdminProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private ProductItem $productItem;

    private Product $product;
    private Category $category;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->asAdmin()->create();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->create(['category_id' => $this->category->id]);
        $this->productItem = ProductItem::factory()->create(['product_id' => $this->product->id]);

    }

    public function test_admin_can_create_product_successfully(): void
    {
        $response = $this->actingAs($this->user);
        $validData = [
            'name' => 'Test Product',
            'description' => 'This is a test product description.',
            'category_id' => $this->category->id,
            'image_path' => 'images/products/test.jpg',
            'items' => [
                [
                    'price' => 10.99,
                    'stock' => 100,
                    'size' => 30,
                    'dough_type' => 'Thin',
                ],
                [
                    'price' => 12.50,
                    'stock' => 50,
                    'size' => 40,
                    'dough_type' => 'Thick',
                ],
            ],
        ];
        $response = $this->post('/api/admin/products/', $validData);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_admin_cannot_create_product_with_invalid_data(): void
    {
        $response = $this->actingAs($this->user);
        $invalidData = [

        ];
        $response = $this->post('/api/admin/products/', $invalidData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_admin_can_update_product_successfully(): void
    {
        $response = $this->actingAs($this->user);
        $validData = [
            'name' => 'Test Product',
            'description' => 'This is a test product description.',
            'category_id' => $this->category->id,
            'image_path' => 'images/products/test.jpg',
        ];
        $response = $this->put('/api/admin/products/' . $this->product->id, $validData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_admin_cannot_update_nonexistent_product(): void
    {
        $response = $this->actingAs($this->user);
        $validData = [
            'name' => 'Test Product',
            'description' => 'This is a test product description.',
            'category_id' => $this->category->id,
            'image_path' => 'images/products/test.jpg',
        ];
        $response = $this->put('/api/admin/products/' . 1000, $validData);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_admin_can_update_product_item_successfully(): void
    {
        $response = $this->actingAs($this->user);
        $validData = [
            'price' => 12.50,
            'stock' => 50,
            'size' => 40,
            'dough_type' => 'Thick',
        ];
        $response = $this->put('/api/admin/product_items/' . $this->productItem->id, $validData);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_admin_cannot_update_product_item_with_invalid_data(): void
    {
        $response = $this->actingAs($this->user);
        $invalidData = [
        ];
        $response = $this->put('/api/admin/product_items/' . $this->productItem->id, $invalidData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_admin_can_delete_product_successfully(): void
    {
        $response = $this->actingAs($this->user);
        $response = $this->delete('/api/admin/products/' . $this->product->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_admin_cannot_delete_nonexistent_product(): void
    {
        $response = $this->actingAs($this->user);
        $response = $this->delete('/api/admin/products/1000');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_admin_can_delete_product_item_successfully(): void
    {
        $response = $this->actingAs($this->user);
        $response = $this->delete('/api/admin/product_items/' . $this->productItem->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_admin_cannot_delete_product_item_that_does_not_exist():void
    {
        $response = $this->actingAs($this->user);
        $response = $this->delete('/api/admin/product_items/1000');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}

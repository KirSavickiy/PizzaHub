<?php

namespace Tests\Feature\User;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;


class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private ProductItem $productItem;
    private Category $category;

    private Product $product;


    public function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();
        $this->product = Product::factory()->create(['category_id' => $this->category->id]);
        $this->productItem = ProductItem::factory()->create(['product_id' => $this->product->id]);
    }

    public function test_can_get_products_list():void
    {
        $response = $this->get('/api/products');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function  test_can_get_single_product_by_id():void
    {
        $response = $this->get('/api/products/' . $this->string($this->productItem->id));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_get_product_with_invalid_id():void
    {
        $response = $this->get('/api/products/999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    private function string(mixed $id)
    {
    }

}


<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Category;
use Illuminate\Http\Response;


class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private ProductItem $productItem;

    public function setUp(): void
    {
        parent::setUp();

        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $this->productItem = ProductItem::factory()->create(['product_id' => $product->id]);
       
    }

    public function test_can_get_products_list():void
    {
        $response = $this->get('/api/products');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function  test_can_get_single_product_by_id():void
    {
        $response = $this->get('/api/products/' . $this->productItem->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_get_product_with_invalid_id():void
    {
        $response = $this->get('/api/products/999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

}


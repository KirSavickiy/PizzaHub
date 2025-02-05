<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ProductItem;
use App\Models\Category;
use App\Models\Product;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create(12);
    }

    public function test_can_get_categories_list():void
    {

    }

    public function test_can_get_single_category_by_id():void
    {

    }

    public function test_cannot_get_category_with_invalid_id():void
    {
        
    }
}

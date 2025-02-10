<?php

namespace Tests\Feature\User;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private Collection $categories;

    public function setUp(): void
    {
        parent::setUp();

        $this->categories = Category::factory()->count(12)->create();
    }

    public function test_can_get_categories_list():void
    {
        $response = $this->get('/api/categories');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_get_single_category_by_id():void
    {
        $response = $this->get('/api/categories/' . $this->categories[rand(0, 11)]->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_get_category_with_invalid_id():void
    {
        $response = $this->get('/api/categories/' . rand(1000, 1000));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}

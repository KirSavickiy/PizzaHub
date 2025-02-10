<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AdminCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private Collection $categories;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->asAdmin()->create();
        $this->categories = Category::factory()->count(12)->create();
    }

    public function test_admin_can_create_category():void
    {
        $this->actingAs($this->user);
        $data = [
            'name' => 'Test Name',
        ];
        $response = $this->post('api/admin/categories', $data);
        $response->assertStatus(Response::HTTP_CREATED);

    }

    public function test_admin_cannot_create_category_with_invalid_data():void
    {
        $this->actingAs($this->user);
        $invalidData = [];
        $response = $this->post('api/admin/categories', $invalidData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_admin_can_update_category():void
    {
        $this->actingAs($this->user);
        $data = [
            'name' => 'Test Name',
        ];
        $response = $this->put('api/admin/categories/' . $this->categories[0]->id, $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_update_nonexistent_category():void
    {
        $this->actingAs($this->user);
        $data = [
            'name' => 'Test Name',
        ];
        $response = $this->put('api/admin/categories/9999', $data);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_admin_can_delete_category():void
    {
        $this->actingAs($this->user);
        $response = $this->delete('api/admin/categories/' . $this->categories[0]->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_admin_cannot_delete_nonexistent_category():void
    {
        $this->actingAs($this->user);
        $response = $this->delete('api/admin/categories/9999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

}

<?php

namespace Tests\Feature\User;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    private Collection $addresses;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->asUser()->create();
        $this->addresses = Address::factory()->count(20)->create(['user_id' => $this->user->id]);
    }

    public function test_can_get_addresses_list(): void
    {
        $this->actingAs($this->user);
        $response = $this->get('/api/addresses');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_get_addresses_list_without_authentication(): void
    {
        $response = $this->get('/api/addresses');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_can_create_address():void
    {
        $this->actingAs($this->user);
        $data = [
            'address_line_1' => 'TEST ADDRESS 1',
            'city' => 'Test City',
        ];
        $response = $this->post('/api/addresses', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_cannot_create_address_with_invalid_data():void
    {
        $this->actingAs($this->user);
        $invalidData = [
            'address_line_1' => '',
            'city' => '!!!',
        ];
        $response = $this->post('/api/addresses', $invalidData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_get_single_address():void
    {
        $this->actingAs($this->user);
        $response = $this->get('/api/addresses/' . $this->addresses[rand(0, 19)]->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_get_nonexistent_address():void
    {
        $this->actingAs($this->user);
        $response = $this->get('/api/addresses/' . rand(21, 100));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_can_update_address():void
    {
        $this->actingAs($this->user);
        $data = [
            'address_line_1' => 'TEST ADDRESS 1',
            'city' => 'Test City',
        ];
        $response = $this->put('/api/addresses/' . $this->addresses[rand(0, 19)]->id, $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_update_address_with_invalid_data():void
    {
        $this->actingAs($this->user);
        $invalidData = [
            'address_line_1' => '',
            'city' => '!!!',
        ];
        $response = $this->put('/api/addresses/' . $this->addresses[rand(0, 19)]->id, $invalidData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_delete_address():void
    {
        $this->actingAs($this->user);
        $response = $this->delete('/api/addresses/' . $this->addresses[rand(0, 19)]->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_delete_nonexistent_address():void
    {
        $this->actingAs($this->user);
        $response = $this->delete('/api/addresses/' . rand(21, 100));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}

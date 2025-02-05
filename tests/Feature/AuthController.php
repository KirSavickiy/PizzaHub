<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthController extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->asUser()->withCart()->create(['email' => 'test@test.com', 'password' => bcrypt('password')]);
    }


    public function test_user_can_login_with_valid_credentials(): void
    {
        $data = [
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['token']);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $data = [
            'email' => 'test@exaple.com',
            'password' => '23222323233',
        ];
        $response = $this->post('/api/login', $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_authenticated_user_cannot_access_login(): void
    {
        $this->actingAs($this->user);
        $this->post('/api/login')->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_user_can_register_with_valid_data(): void
    {
        $data = [
            'first_name' => 'Name',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
            'phone' => '80299865798',
            'birth_date' => '01.01.2000',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $this->post('/api/register', $data)->assertStatus(Response::HTTP_CREATED);
    }

    public function test_user_cannot_register_with_invalid_data(): void
    {
        $data = [
            'first_name' => 'Name',
            'email' => '!!!!',
            'phone' => '80299865798',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $this->post('/api/register', $data)->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_authenticated_user_can_logout(): void
    {
        $this->actingAs($this->user);
        $this->post('/api/logout')->assertStatus(Response::HTTP_OK);

    }

    public function test_guest_cannot_logout():void
    {

    }





}

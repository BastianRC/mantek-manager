<?php

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Tests\TestCase;

class CreateUserEndpointTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate(): string
    {
        UserEloquent::factory()->create([
            'email' => 'john@gmail.com',
            'password' => bcrypt('Secret.123')
        ]);

        return $this->postJson('/api/auth/login', [
            'email' => 'john@gmail.com',
            'password' => 'Secret.123'
        ])['data']['token'];
    }

    public function test_create_user_endpoint_returns_201_when_data_is_valid()
    {
        $token = $this->authenticate();

        $response = $this->postJson('/api/users', [
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com',
            'password' => 'Secret.123'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'email',
                'name',
                'created_at',
                'updated_at'
            ]
        ]);

        $this->assertTrue($response->json('success'));
        $this->assertEquals('User created successfully.', $response->json('message'));
        $this->assertEquals('jane@gmail.com', $response->json('data.email'));

        $this->assertDatabaseHas('users', [
            'email' => 'jane@gmail.com',
            'name' => 'Jane Doe'
        ]);

        $this->assertArrayNotHasKey('password', $response->json('data'));
    }

    public function test_create_user_endpoint_returns_422_when_name_and_password_are_missing()
    {
        $token = $this->authenticate();

        $response = $this->postJson('/api/users', [
            'name' => '',
            'email' => 'jane@example.com',
            'password' => ''
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'password']);
        $this->assertEquals('The name field is required.', $response->json('errors.name')[0]);
        $this->assertEquals('The password field is required.', $response->json('errors.password')[0]);
    }

    public function test_create_user_endpoint_returns_422_when_password_does_not_meet_requirements()
    {
        $token = $this->authenticate();

        $response = $this->postJson('/api/users', [
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com',
            'password' => 'bad-password'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
        $this->assertEquals('The password must contain at least one uppercase letter and one special character.', $response->json('errors.password')[0]);
    }

    public function test_create_user_endpoint_returns_422_when_email_is_invalid()
    {
        $token = $this->authenticate();

        $response = $this->postJson('/api/users', [
            'name' => 'Jane Doe',
            'email' => 'jane@gmail',
            'password' => 'Secret.123'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
        $this->assertEquals('Please provide a valid email address.', $response->json('errors.email')[0]);
    }

    public function test_create_user_endpoint_returns_409_when_email_already_exists()
    {
        $token = $this->authenticate();

        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => 'Secret.123'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(409);
        $response->assertJsonStructure([
            'success',
            'message',
        ]);

        $this->assertFalse($response->json('success'));
        $this->assertEquals('Email already in use.', $response->json('message'));
    }
}

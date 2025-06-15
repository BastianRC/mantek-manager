<?php

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Tests\TestCase;

class UpdateUserEndpointTest extends TestCase
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

    public function test_update_user_endpoint_returns_200_when_user_is_updated_successfully()
    {
        $token = $this->authenticate();

        $response = $this->patchJson('/api/users/1', [
            'name' => 'Test Doe'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
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
        $this->assertEquals('User updated successfully.', $response->json('message'));
        $this->assertEquals('Test Doe', $response->json('data.name'));
        $this->assertEquals('john@gmail.com', $response->json('data.email'));
        $this->assertIsArray($response->json('data'));
    }

    public function test_update_user_endpoint_returns_404_when_user_not_found()
    {
        $token = $this->authenticate();

        $response = $this->patchJson('/api/users/2', [
            'name' => 'Test Doe'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'success',
            'message',
        ]);

        $this->assertFalse($response->json('success'));
        $this->assertEquals('User not found.', $response->json('message'));
    }

    public function test_update_user_endpoint_returns_422_when_data_is_invalid()
    {
        $token = $this->authenticate();

        $response = $this->patchJson('/api/users/1', [
            'email' => 'john@hotmail',
            'password' => 'bad-password'
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);

        $this->assertEquals('Please provide a valid email address.', $response->json('errors.email')[0]);
        $this->assertEquals('The password must contain at least one uppercase letter and one special character.', $response->json('errors.password')[0]);
    }

    public function test_update_user_endpoint_returns_401_when_user_is_not_authenticated()
    {
        $response = $this->patchJson('/api/users/1', [
            'Authorization' => 'Bearer ' . 'not_token_or_invalid'
        ]);

        $response->assertStatus(status: 401);
        $this->assertEquals('Unauthenticated.', $response->json('message'));
    }
}

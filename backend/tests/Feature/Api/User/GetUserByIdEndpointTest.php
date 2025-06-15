<?php

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Tests\TestCase;

class GetUserByIdEndpointTest extends TestCase
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

    public function test_get_user_by_id_endpoint_returns_200_when_user_exists()
    {
        UserEloquent::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com'
        ]);

        $token = $this->authenticate();

        $response = $this->getJson('/api/users/1', [
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
        $this->assertEquals('User retrieved successfully.', $response->json('message'));
        $this->assertEquals('jane@gmail.com', $response->json('data.email'));
        $this->assertIsArray($response->json('data'));
    }

    public function test_get_user_by_id_endpoint_returns_404_when_user_not_found()
    {
        $token = $this->authenticate();

        $response = $this->getJson('/api/users/2', [
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

    public function test_get_user_by_id_endpoint_returns_401_when_user_is_not_authenticated()
    {
        $response = $this->getJson('/api/users/1', [
            'Authorization' => 'Bearer ' . 'not_token_or_invalid'
        ]);

        $response->assertStatus(status: 401);
        $this->assertEquals('Unauthenticated.', $response->json('message'));
    }
}

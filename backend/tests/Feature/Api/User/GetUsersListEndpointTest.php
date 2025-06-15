<?php

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Tests\TestCase;

class GetUsersListEndpointTest extends TestCase
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

    public function test_get_users_list_endpoint_returns_200_when_user_is_authenticated()
    {
        UserEloquent::factory()->count(10)->create();

        $token = $this->authenticate();

        $response = $this->getJson('/api/users', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'email',
                    'name',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);

        $this->assertTrue($response->json('success'));
        $this->assertEquals('Users retrieved successfully.', $response->json('message'));
        $this->assertIsArray($response->json('data'));
        $this->assertCount(11, $response->json('data'));
    }

    public function test_get_users_list_endpoint_returns_401_when_user_is_not_authenticated()
    {
        $response = $this->getJson('/api/users', [
            'Authorization' => 'Bearer ' . 'not_token_or_invalid'
        ]);

        $response->assertStatus(status: 401);
        $this->assertEquals('Unauthenticated.', $response->json('message'));
    }
}

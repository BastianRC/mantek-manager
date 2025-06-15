<?php

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Tests\TestCase;

class DeleteUserEndpointTest extends TestCase
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

    public function test_delete_user_endpoint_returns_200_when_user_is_deteled_successfully()
    {
        $delete = UserEloquent::factory()->create();

        $token = $this->authenticate();

        $response = $this->deleteJson('/api/users/' . $delete->id, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
        ]);

        $this->assertTrue($response->json('success'));
        $this->assertEquals('User deleted successfully.', $response->json('message'));
        $this->assertCount(1, UserEloquent::all());
    }

    public function test_delete_user_endpoint_returns_404_when_user_not_found()
    {
        $token = $this->authenticate();

        $response = $this->deleteJson('/api/users/2', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(status: 404);
        $response->assertJsonStructure([
            'success',
            'message',
        ]);

        $this->assertFalse($response->json('success'));
        $this->assertEquals('User not found.', $response->json('message'));
    }

    public function test_delete_user_endpoint_returns_401_when_user_is_not_authenticated()
    {
        $response = $this->deleteJson('/api/users/1', [
            'Authorization' => 'Bearer ' . 'not_token_or_invalid'
        ]);

        $response->assertStatus(status: 401);
        $this->assertEquals('Unauthenticated.', $response->json('message'));
    }
}
<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Tests\TestCase;

class ValidateUserEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_validate_user_endpoint_is_successful_when_user_is_valid()
    {
        $user = UserEloquent::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('Secret.123')
        ]);

        $responseLogin = $this->postJson('/api/auth/login', [
            'email' => 'john@example.com',
            'password' => 'Secret.123'
        ]);

        $responseValidate = $this->getJson('/api/auth/validate', [
            'Authorization' => 'Bearer '. $responseLogin['data']['token']
        ]);

        $responseValidate->assertStatus(200);
        $responseValidate->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
                'email'
            ]
        ]);

        $this->assertTrue($responseValidate->json('success')); 
        $this->assertEquals('User has been successfully validated.', $responseValidate->json('message'));
        $this->assertEquals('john@example.com', $responseValidate->json('data.email'));
    }

    public function test_validate_user_endpoint_returns_401_when_user_is_not_authenticated()
    {
        $response = $this->getJson('/api/auth/validate');

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message'
        ]);

        $this->assertEquals('Unauthenticated.', $response->json('message'));
    }
}
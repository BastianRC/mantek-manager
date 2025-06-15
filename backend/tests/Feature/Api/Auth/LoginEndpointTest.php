<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;
use Tests\TestCase;

class LoginEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_endpoint_is_successful_when_credentials_are_valid(): void
    {
        $user = UserEloquent::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('Secret.123')
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'john@example.com',
            'password' => 'Secret.123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email'
                ]
            ]
        ]);

        $this->assertTrue($response->json('success'));
        $this->assertEquals('Successful login.', $response->json('message'));
        $this->assertEquals('john@example.com', $response->json('data.user.email'));
    }

    public function test_login_endpoint_returns_401_when_credentials_are_wrong()
    {
        $user = UserEloquent::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('Secret.123')
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'john@example.com',
            'password' => 'Wrong.password'
        ]);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'success',
            'message',
        ]);

        $this->assertFalse($response->json('success'));
        $this->assertEquals('Invalid credentials', $response->json('message'));
    }

    public function test_login_endpoint_returns_422_when_email_and_password_are_missing_or_invalid()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'john.com',
            'password' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);

        $this->assertStringContainsString('email', strtolower($response->json('message')));
        $this->assertEquals('The email field must be a valid email address.', $response->json('errors.email')[0]);
        $this->assertEquals('The password field is required.', $response->json('errors.password')[0]);
    }

    public function test_login_endpoint_returns_422_when_password_does_not_meet_complexity_requirements()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);

        $this->assertEquals(
            'The password must contain at least one uppercase letter and one special character.',
            $response->json('errors.password')[0]
        );
    }
}

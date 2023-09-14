<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_get_an_api_token_when_authentication_passes(): void
    {
        $user = User::create([
            'email' => 'acme@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertExactJson([
            'token' => $response->json('token')
        ]);
    }

    public function test_user_authentication_fails_when_password_is_invalid(): void
    {
        $user = User::create([
            'email' => 'acme@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }
}
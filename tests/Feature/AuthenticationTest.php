<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = $this->createTestUser('correct-password');

        $response = $this->post(route('login'), [
            'username' => $user->username,
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = $this->createTestUser('correct-password');

        $response = $this->from(route('login'))
            ->post(route('login'), [
                'username' => $user->username,
                'password' => 'wrong-password',
            ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = $this->createTestUser('correct-password');

        $response = $this->actingAs($user)
            ->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    private function createTestUser(string $password): User
    {
        return User::query()->create([
            'username' => 'auth-test-' . uniqid(),
            'password_hash' => Hash::make($password),
            'full_name' => 'Pengguna Pengujian',
            'role' => 'admin',
        ]);
    }
}
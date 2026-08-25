<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'StrongPass@123',
            'password_confirmation' => 'StrongPass@123',
            'gdpr' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_registration_requires_a_strong_password(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'weakpass',
            'password_confirmation' => 'weakpass',
        ]);

        $this->assertGuest();
        $response
            ->assertRedirect('/register')
            ->assertSessionHasErrors('password');
    }

    public function test_registration_requires_gdpr_consent(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'StrongPass@123',
            'password_confirmation' => 'StrongPass@123',
        ]);

        $this->assertGuest();
        $response
            ->assertRedirect('/register')
            ->assertSessionHasErrors('gdpr');
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }
}

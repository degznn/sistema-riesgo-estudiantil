<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_guest_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_api_login_returns_sanctum_token(): void
    {
        User::factory()->create([
            'email' => 'demo@tecsup.edu.pe',
            'password' => bcrypt('password'),
            'role' => 'administrador',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'demo@tecsup.edu.pe',
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['token_type', 'access_token', 'user']);
    }
}

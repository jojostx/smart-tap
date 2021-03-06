<?php

namespace Tests\Feature\Auth\Client;

use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_clients_can_authenticate_using_the_login_screen()
    {
        $client = Client::factory()->create();

        $response = $this->post('/login', [
            'email' => $client->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_clients_can_not_authenticate_with_invalid_password()
    {
        $client = Client::factory()->create();

        $this->post('/login', [
            'email' => $client->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}

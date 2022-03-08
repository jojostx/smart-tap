<?php

namespace Tests\Feature\Auth\Admin;

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
    }

    public function test_clients_can_authenticate_using_the_login_screen()
    {
        $client = Admin::factory()->create();

        $response = $this->post(route('admin.login'), [
            'email' => $client->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('admin');
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_clients_can_not_authenticate_with_invalid_password()
    {
        $client = Admin::factory()->create();

        $this->post(route('admin.login'), [
            'email' => $client->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}

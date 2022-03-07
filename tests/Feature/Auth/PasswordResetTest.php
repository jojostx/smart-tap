<?php

namespace Tests\Feature\Auth;

use App\Models\Client;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $client = Client::factory()->create();

        $this->post('/forgot-password', ['email' => $client->email]);

        Notification::assertSentTo($client, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $client = Client::factory()->create();

        $this->post('/forgot-password', ['email' => $client->email]);

        Notification::assertSentTo($client, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $client = Client::factory()->create();

        $this->post('/forgot-password', ['email' => $client->email]);

        Notification::assertSentTo($client, ResetPassword::class, function ($notification) use ($client) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $client->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}

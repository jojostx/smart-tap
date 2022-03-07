<?php

namespace Tests\Feature\Auth;

use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered()
    {
        $client = Client::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($client)->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        $client = Client::factory()->create([
            'email_verified_at' => null,
        ]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $client->id, 'hash' => sha1($client->email)]
        );

        $response = $this->actingAs($client)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($client->fresh()->hasVerifiedEmail());
        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $client = Client::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $client->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($client)->get($verificationUrl);

        $this->assertFalse($client->fresh()->hasVerifiedEmail());
    }
}

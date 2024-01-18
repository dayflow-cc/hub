<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class OneTimeTokenTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function itLoginsAUserWithAOneTimeToken()
    {
        $user = User::factory()->create();
        $this->postJson(route('auth.one-time-token.create'), ['email' => $user->email])
            ->assertSuccessful();

        $tokens = \Cache::get('user:' . $user->id . ':one-time-token');
        $this->assertCount(1, $tokens);

        $this->postJson(route('auth.one-time-token.login'), [
            'email' => $user->email,
            'token' => (string)end($tokens),
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                                      'access_token',
                                      'token_type',
                                      'expires_in',
                                  ]);

        $this->assertNull(\Cache::get('user:' . $user->id . ':one-time-token'));
    }

    /** @test */
    public function itAllowsToLoginWithAnOldToken()
    {
        $user = User::factory()->create();
        $tokens = [123456, 987654, 654321];
        \Cache::set('user:' . $user->id . ':one-time-token', $tokens, 120);

        $this->postJson(route('auth.one-time-token.login'), [
            'email' => $user->email,
            'token' => (string)$tokens[0],
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                                      'access_token',
                                      'token_type',
                                      'expires_in',
                                  ]);
    }

    /** @test */
    public function itFailsToLoginExpiredTokens()
    {
        $user = User::factory()->create();
        $this->postJson(route('auth.one-time-token.create'), ['email' => $user->email])
            ->assertSuccessful();

        $tokens = \Cache::get('user:' . $user->id . ':one-time-token');
        \Cache::delete('user:' . $user->id . ':one-time-token');

        $this->postJson(route('auth.one-time-token.login'), [
            'email' => $user->email,
            'token' => (string)end($tokens),
        ])
            ->assertUnauthorized();
    }

}

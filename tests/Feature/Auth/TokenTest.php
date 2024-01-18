<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TokenTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function itIssuesTokens()
    {
        $user = User::factory()->create(['password' => 'secret']);
        $this->postJson('auth/v1/token', [
            'email' => $user->email,
            'password' => 'secret',
        ])
            ->assertOk()
            ->assertJsonStructure([
                                      'token_type',
                                      'expires_in',
                                      'access_token',
                                  ]);
    }

    /** @test */
    public function itFailsToIssueTokenForInvalidCredentials()
    {
        $user = User::factory()->create(['password' => 'secret']);
        $this->postJson('auth/v1/token', [
            'email' => $user->email,
            'password' => 'foo',
        ])
            ->assertUnauthorized();
    }
}

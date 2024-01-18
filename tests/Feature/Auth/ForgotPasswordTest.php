<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function itSendsAPasswordResetNotification()
    {
        $user = User::factory()->create();
        $this->postJson(route('auth.password.email'), [
            'email' => $user->email,
        ])->assertSuccessful();
    }

    /** @test */
    public function itResetsThePassword()
    {
        $user = User::factory()->create();
        $token = Password::broker()->createToken($user);

        $this->postJson(route('auth.password.reset'), [
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
            'token' => $token,
        ])->assertSuccessful();
    }
}

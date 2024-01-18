<?php

namespace Tests\Feature\Api\User;

use App\Events\User\PasswordChanged;
use Hash;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function aUserCanChangeTheirPassword()
    {
        Event::fake();
        $this->createAndActAs();
        $this->postJson(route('api.users.me.password'), [
            'oldPassword' => 'password',
            'password' => 'new-password',
            'passwordConfirmation' => 'new-password',
        ])
            ->assertNoContent();

        $this->user->refresh();
        $this->assertTrue(Hash::check('new-password', $this->user->password));

        Event::assertDispatched(PasswordChanged::class);
    }

    /** @test */
    public function aUserCantChangeTheirPasswordWithProvidingAWrong()
    {
        $this->createAndActAs();
        $this->postJson(route('api.users.me.password'), [
            'oldPassword' => 'wrong-password',
            'password' => 'new-password',
            'passwordConfirmation' => 'new-password',
        ])
            ->assertForbidden();
    }
}

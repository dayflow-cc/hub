<?php

namespace Tests\Feature\Auth;

use App\Http\Middleware\PreventDuringImpersonation;
use App\Http\Resources\User\OwnUserResource;
use App\Models\User;
use App\Services\Auth\ImpersonationService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ImpersonationTest extends TestCase
{
    use DatabaseMigrations;

    protected User $impersonatedUser;
    protected User $superuser;

    public function setUp(): void
    {
        parent::setUp();
        $this->superuser = User::factory()->create(['is_root' => true]);
        $this->impersonatedUser = User::factory()->create();
    }

    /** @test */
    public function itReturnsANewTokenForTheImpersonatedUser(): void
    {
        $guard = $this->app['auth']->guard('api');

        $response = $this->postJson(route('auth.impersonate.store'), ['userId' => $this->impersonatedUser->getRouteKey()], [
            'Authorization' => 'Bearer ' . $guard->tokenById($this->superuser->getRouteKey()),
        ])->assertOk();

        $token = $response->json()['access_token'];

        $jwt = $guard->setToken($token);
        $this->assertTrue($jwt->payload()->matches([
            'sub' => $this->impersonatedUser->getRouteKey(),
            'ruid' => $this->superuser->getRouteKey(),
        ]));
    }

    /** @test */
    public function itImpersonatesAUser(): void
    {
        auth()->setDefaultDriver('api');
        /** @var ImpersonationService $service */
        $service = $this->app->make(ImpersonationService::class);

        $this->getJson(route('api.users.me.show'), [
            'Authorization' => 'Bearer ' . $service->impersonate($this->superuser, $this->impersonatedUser),
        ])->assertOk()
            ->assertJson([
                'data' => OwnUserResource::make($this->impersonatedUser)->resolve(),
            ]);
    }

    /** @test */
    public function itPreventsImpersonation(): void
    {
        $guard = $this->app['auth']->guard('api');
        $this->postJson(route('auth.impersonate.store'), ['userId' => $this->superuser->getRouteKey()], [
            'Authorization' => 'Bearer ' . $guard->tokenById($this->impersonatedUser->getRouteKey()),
        ])->assertForbidden();
    }

    /** @test */
    public function itDisallowsActionsWithAMiddleware(): void
    {
        Route::get('/test', function () {
            return response(null, 204);
        })->middleware([PreventDuringImpersonation::class]);

        $this->getJson('/test')
            ->assertNoContent();

        $token = $this->app['auth']->guard('api')->claims([
            ImpersonationService::CLAIM_REAL_USER_ID => $this->superuser->getRouteKey(),
        ])->tokenById($this->impersonatedUser->getRouteKey());
        $this->getJson('/test', [
            'Authorization' => 'Bearer ' . $token
        ])->assertForbidden();
    }
}

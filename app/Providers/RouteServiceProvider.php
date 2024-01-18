<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return [
                Limit::perMinute(60)->by("login|{$request->ip()}"),
                Limit::perMinute(5)->by("login|{$request->input('email')}"),
            ];
        });

        RateLimiter::for('one-time', function (Request $request) {
            return [
                Limit::perMinute(5)->by("one-time|{$request->ip()}"),
                Limit::perMinute(1)->by("one-time|{$request->input('email')}"),
            ];
        });

        RateLimiter::for('crucial', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::prefix('auth/v1')
                ->middleware('api')
                ->name('auth.')
                ->group(base_path('routes/auth.php'));

            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.')
                ->group(base_path('routes/public_api.php'));

            Route::middleware(['api', 'auth:api'])
                ->prefix('api/v1')
                ->name('api.')
                ->group(base_path('routes/private_api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}

<?php

namespace App\Http\Controllers\Api;

class HealthController
{
    public function __invoke(): array
    {
        return [
            'status' => 'ok',
            'version' => config('app.version'),
            'timestamp' => now()->toIso8601String(),
        ];
    }
}

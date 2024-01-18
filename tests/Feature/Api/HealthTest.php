<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class HealthTest extends TestCase
{
    /** @test */
    public function itReturnsData()
    {
        $this->getJson('api/v1/health')
            ->assertOk()
            ->assertJson([
                'status' => 'ok',
                'version' => config('app.version'),
                'timestamp' => now()->toIso8601String(),
            ]);
    }
}

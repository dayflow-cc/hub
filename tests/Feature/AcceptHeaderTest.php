<?php

namespace Tests\Feature;

use Tests\TestCase;

class AcceptHeaderTest extends TestCase
{
    /**
     * @test
     * @dataProvider localeDataProvider
     */
    public function itSetsLocales($supported, $accept, $expected)
    {
        config()->set('app.locales', $supported);
        app()->setLocale('foo');
        $this->getJson('api/v1/health', ['accept-language' => $accept]);
        $this->assertEquals($expected, app()->getLocale());
    }

    public static function localeDataProvider()
    {
        return [
            'en' => [
                ['en', 'de'],
                'en-US,en;q=0.9,de;q=0.8,de-AT;q=0.7',
                'en',
            ],
            'de-only' => [
                ['de'],
                'en-US,en;q=0.9,de;q=0.8,de-AT;q=0.7',
                'de',
            ],
            'de' => [
                ['en', 'de'],
                'de,de-AT;q=0.9,en-US;q=0.7,',
                'de',
            ],
            'non-supported' => [
                ['en', 'de'],
                'fr',
                'en',
            ],
        ];
    }
}

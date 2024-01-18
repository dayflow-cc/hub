<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use CodersCantina\Translations\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use stdClass;
use function response;

class TranslationController extends Controller
{
    protected const DEFAULT_LANGUAGE = 'en';

    public function __invoke(Request $request)
    {
        $namespaces = explode(',', $request->get('ns'));
        $result = [];
        $language = $request->getPreferredLanguage(config('app.locales'));

        $result = $this->applyLanguage(self::DEFAULT_LANGUAGE, $namespaces, $result);

        if ($language !== self::DEFAULT_LANGUAGE) {
            $result = $this->applyLanguage($language, $namespaces, $result);
        }

        return response()->json(count($result) ? $result : new stdClass(), 200, ['Vary' => 'Accept-Language']);
    }

    protected function applyLanguage(string $language, array $namespaces, array $result): array
    {
        Translation::where('language_iso', $language)
            ->whereIn('namespace', $namespaces)
            ->each(function (Translation $t) use (&$result) {
                Arr::set($result[$t->namespace], $t->key, $t->value);
            });

        return $result;
    }

}

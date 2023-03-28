<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FrontEnd
{
    /**
     * @param  string  $routeName
     * @param  array|string|null  $parameters
     */
    public static function route(string $routeName, array|string|null $parameters = null): string
    {
        $routes = config('frontend.routes');
        $routeTemplate = $routes[$routeName] ?? null;

        if (! $routeTemplate) {
            throw new \Exception("FrontEnd route [$routeName] does not exists");
        }

        $relativeUrl = static::buildRelativeUrl($routeTemplate, Arr::wrap($parameters));

        return config('app.spa_url') . '/' . ltrim($relativeUrl, '/');
    }

    private static function buildRelativeUrl(string $template, array $params): string
    {
        $urlParamsInTemplate = Str::of($template)
            ->matchAll('/\{([-a-zA-Z_]+?)\}/');

        $queryStrings = collect($params)
            ->except($urlParamsInTemplate)
            ->filter(fn ($value, $key) => ! is_numeric($key))
            ->implode(fn ($value, $key) => "$key=$value", '&');

        $relativePath = apply_params($template, $params, '{', '}');

        return $relativePath . ($queryStrings ? "?$queryStrings" : '');
    }
}

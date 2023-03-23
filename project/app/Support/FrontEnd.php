<?php

namespace App\Support;

use Illuminate\Support\Arr;

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

        $routeUrl = static::applyParams($routeTemplate, Arr::wrap($parameters));

        return config('app.spa_url') . '/' . ltrim($routeUrl, '/');
    }

    private static function applyParams(string $template, array $params)
    {
        return apply_params($template, $params, '{', '}');
    }
}

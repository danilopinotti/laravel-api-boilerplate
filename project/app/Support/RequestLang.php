<?php

namespace App\Support;

use Illuminate\Support\Collection;

class RequestLang
{
    public static function getLocaleByHttpAcceptHeader($httpAcceptLanguagesHeader): string
    {
        if (! $httpAcceptLanguagesHeader) {
            return '';
        }

        $list = explode(',', $httpAcceptLanguagesHeader);
        $locales = Collection::make($list)
            ->map(function ($locale) {
                $parts = explode(';', $locale);
                $mapping['locale'] = trim($parts[0]);

                if (isset($parts[1])) {
                    $factorParts = explode('=', $parts[1]);
                    $mapping['factor'] = $factorParts[1];
                } else {
                    $mapping['factor'] = 1;
                }

                return $mapping;
            })
            ->sortByDesc(function ($locale) {
                return $locale['factor'];
            });

        return str_replace('-', '_', $locales->first()['locale']);
    }
}

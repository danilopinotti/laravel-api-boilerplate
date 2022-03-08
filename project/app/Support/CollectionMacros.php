<?php

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CollectionMacros
{
    public static function register()
    {
        static::registerPaginate();
        static::registerAllEquals();
    }

    private static function registerPaginate()
    {
        Collection::macro('paginate', function ($perPage, $currentPage = null) {
            $currentPage = $currentPage ?? LengthAwarePaginator::resolveCurrentPage();
            $items = $this->values();
            $total = $this->count();

            return new LengthAwarePaginator(
                $items->forPage($currentPage, $perPage),
                $total,
                $perPage,
                $currentPage
            );
        });
    }

    private static function registerAllEquals()
    {
        Collection::macro('allEquals', function (callable $callback = null): bool {
            if ($this->isEmpty()) {
                return true;
            }

            $callback = $callback ?? fn ($element) => $element;

            $baseToCompare = $callback($this->first());

            return $this->every(function ($element) use ($callback, $baseToCompare) {
                return $baseToCompare === $callback($element);
            });
        });
    }
}

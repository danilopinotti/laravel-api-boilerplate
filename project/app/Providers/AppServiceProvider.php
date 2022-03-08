<?php

namespace App\Providers;

use App\Domains\User\Models\User;
use App\Support\CacheManager;
use App\Support\CollectionMacros;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CacheManager::class, function ($app) {
            return new CacheManager();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        Carbon::setLocale(config('app.locale'));

        $this->loadMorphMap();
        $this->loadMacros();

        Model::preventLazyLoading(!app()->isProduction());
    }

    private function loadMorphMap()
    {
        Relation::morphMap([
            'user' => User::class,
        ]);
    }

    private function loadMacros(): void
    {
        CollectionMacros::register();
        Builder::macro('applyCriteria', function ($criteria) {
            foreach (Arr::wrap($criteria) as $criterion) {
                $criterion->apply($this);
            }
            return $this;
        });
    }
}

<?php

namespace App\Providers;

use App\Support\FrontEnd;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return FrontEnd::route('auth.reset-password', ['token' => $token]);
        });
    }
}

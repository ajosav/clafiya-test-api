<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
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
        $this->registerPolicies();
        
        if (! $this->app->routesAreCached()) {
            Passport::routes(function ($router) {
                $router->forAccessTokens();
                $router->forPersonalAccessTokens();
                $router->forTransientTokens();
            });
        }

        Passport::tokensExpireIn(Carbon::now()->addMinutes(10));
        
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));
        //
    }
}

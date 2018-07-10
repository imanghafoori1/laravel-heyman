<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class HeyManServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Gate::define('heyman.youShouldHaveRole', function ($user, $role) {
            return $user->hasRole($role);
        });

        $this->loadMigrationsFrom(__DIR__.'/migrations');
        (new RouteAuthorizer())->authorizeMatchedRoutes($this->app);
    }

    public function register()
    {
        $this->app->singleton('hey_man', HeyMan::class);
        $this->app->singleton('hey_man_authorizer', ConditionApplier::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/heyMan.php',
            'heyMan'
        );
    }
}
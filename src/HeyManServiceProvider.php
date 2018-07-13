<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class HeyManServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->defineGates();

        $this->loadMigrationsFrom(__DIR__.'/migrations');
        (new RouteAuthorizer())->authorizeMatchedRoutes($this->app);
    }

    public function register()
    {
        $this->app->singleton('hey_man', HeyMan::class);
        $this->app->singleton('hey_man_authorizer', ConditionApplier::class);
        $this->app->singleton('hey_man_route_authorizer', RouteConditionApplier::class);
        $this->app->singleton(YouShouldHave::class, YouShouldHave::class);
        $this->app->singleton('hey_man_responder', Responder::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/heyMan.php',
            'heyMan'
        );
    }

    private function defineGates(): void
    {
        Gate::define('heyman.youShouldHaveRole', function ($user, $role) {
            return $user->hasRole($role);
        });
    }
}
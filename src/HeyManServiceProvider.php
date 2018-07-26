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
        $this->registerSingletons();

        $this->mergeConfigFrom(
            __DIR__.'/../config/heyMan.php',
            'heyMan'
        );
    }

    private function defineGates()
    {
        Gate::define('heyman.youShouldHaveRole', function ($user, $role) {
            return $user->role == $role;
        });
    }

    private function registerSingletons()
    {
        $this->app->singleton(Chain::class, Chain::class);
        $this->app->singleton(HeyMan::class, HeyMan::class);
        $this->app->singleton('hey_man_responder', Redirector::class);
        $this->app->singleton(YouShouldHave::class, YouShouldHave::class);
        $this->app->singleton(ListenerFactory::class, ListenerFactory::class);
        $this->app->singleton(ListenerApplier::class, ListenerApplier::class);
        $this->app->singleton(RouteConditionApplier::class, RouteConditionApplier::class);
    }
}

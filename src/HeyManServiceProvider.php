<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\ServiceProvider;

class HeyManServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        (new RouteAuthorizer())->authorizeMatchedRoutes($this->app);
    }

    public function register()
    {
        $this->app->singleton('hey_man', HeyMan::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/heyMan.php',
            'heyMan'
        );
    }
}
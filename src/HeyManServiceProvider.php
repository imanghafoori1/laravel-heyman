<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\{Facades\Gate, ServiceProvider};
use Imanghafoori\HeyMan\Boot\{DebugbarIntergrator, Singletons};
use Imanghafoori\HeyMan\WatchingStrategies\AllEventManagers;

final class HeyManServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->defineGates();

        $this->loadMigrationsFrom(__DIR__.'/migrations');

        app()->booted([AllEventManagers::class, 'start']);

        DebugbarIntergrator::register();
    }

    public function register()
    {
        Singletons::make($this->app);

        AliasLoader::getInstance()->alias('HeyMan', \Imanghafoori\HeyMan\Facades\HeyMan::class);

        $this->mergeConfigFrom(__DIR__.'/../config/heyMan.php', 'heyMan');
    }

    private function defineGates()
    {
        Gate::define('heyman.youShouldHaveRole', function ($user, $role) {
            return $user->role == $role;
        });
    }
}

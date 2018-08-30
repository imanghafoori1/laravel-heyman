<?php

namespace Imanghafoori\HeyMan;

use DebugBar\DataCollector\MessagesCollector;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\{Facades\Gate, ServiceProvider};
use Imanghafoori\HeyMan\Boot\{DebugbarIntergrator, Singletons};
use Imanghafoori\HeyMan\WatchingStrategies\{EloquentEventsManager, EventManager, RouterEventManager, ViewEventManager};

class HeyManServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->defineGates();

        $this->loadMigrationsFrom(__DIR__.'/migrations');

        app()->booted(function () {
            app(RouterEventManager::class)->start();
            app(EventManager::class)->start();
            app(ViewEventManager::class)->start();
            app(EloquentEventsManager::class)->start();
        });
        DebugbarIntergrator::register($this->app);
    }

    public function register()
    {
        Singletons::make($this->app);
        AliasLoader::getInstance()->alias('HeyMan',\Imanghafoori\HeyMan\Facades\HeyMan::class);
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
}

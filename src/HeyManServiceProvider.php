<?php

namespace Imanghafoori\HeyMan;

use DebugBar\DataCollector\MessagesCollector;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Imanghafoori\HeyMan\Boot\DebugbarIntergrator;
use Imanghafoori\HeyMan\Reactions\ReactionFactory;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;

class HeyManServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->defineGates();

        $this->loadMigrationsFrom(__DIR__.'/migrations');

        app()->booted(function () {
            (new RouteMatchListener())->authorizeMatchedRoutes();
            app(EventManager::class)->start();
            app(ViewEventManager::class)->start();
            app(EloquentEventsManager::class)->start();
        });
        DebugbarIntergrator::register($this->app);
    }

    public function register()
    {
        $this->registerSingletons();
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

    private function registerSingletons()
    {
        $singletons = [
            HeyManSwitcher::class,
            Chain::class,
            HeyMan::class,
            YouShouldHave::class,
            ReactionFactory::class,
            EventManager::class,
            RouterEventManager::class,
            ViewEventManager::class,
            EloquentEventsManager::class,
        ];

        array_walk($singletons, function ($class) {
            $this->app->singleton($class, $class);
        });
    }
}

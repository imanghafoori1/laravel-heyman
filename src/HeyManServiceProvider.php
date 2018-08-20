<?php

namespace Imanghafoori\HeyMan;

use DebugBar\DataCollector\MessagesCollector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
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
        $this->_registerDebugbar();
    }

    private function _registerDebugbar()
    {
        if (!$this->app->offsetExists('debugbar')) {
            return;
        }

        $this->app->singleton('heyman.debugger', function () {
            return new MessagesCollector('HeyMan');
        });

        $this->app->make('debugbar')->addCollector(app('heyman.debugger'));

        \Event::listen('heyman_reaction_is_happening', function (...$debug) {
            app('heyman.debugger')->addMessage('HeyMan Rule Matched in file: '.$debug[0]);
            app('heyman.debugger')->addMessage('on line: '.$debug[1]);
            app('heyman.debugger')->addMessage($debug[2]);
        });
    }

    public function register()
    {
        $this->registerSingletons();

        //$this->app->alias(\Imanghafoori\HeyMan\Facades\HeyMan::class, 'HeyMan');
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
        $this->app->singleton(HeyManSwitcher::class, HeyManSwitcher::class);
        $this->app->singleton(Chain::class, Chain::class);
        $this->app->singleton(HeyMan::class, HeyMan::class);
        $this->app->singleton(YouShouldHave::class, YouShouldHave::class);
        $this->app->singleton(ReactionFactory::class, ReactionFactory::class);
        $this->app->singleton(EventManager::class, EventManager::class);
        $this->app->singleton(RouterEventManager::class, RouterEventManager::class);
        $this->app->singleton(ViewEventManager::class, ViewEventManager::class);
        $this->app->singleton(EloquentEventsManager::class, EloquentEventsManager::class);
    }
}

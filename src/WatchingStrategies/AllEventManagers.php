<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;


class AllEventManagers
{
    public static function start()
    {
        app(RouterEventManager::class)->start();
        app(EventManager::class)->start();
        app(ViewEventManager::class)->start();
        app(EloquentEventsManager::class)->start();
    }
}
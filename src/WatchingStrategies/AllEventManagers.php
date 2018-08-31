<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class AllEventManagers
{
    public static function start()
    {
        resolve(RouterEventManager::class)->start();
        resolve(EventManager::class)->start();
        resolve(ViewEventManager::class)->start();
        resolve(EloquentEventsManager::class)->start();
    }
}

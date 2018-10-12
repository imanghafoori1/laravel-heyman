<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\WatchingStrategies\{EloquentModels\EloquentEventsManager, Routes\RouterEventManager, Views\ViewEventManager};

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

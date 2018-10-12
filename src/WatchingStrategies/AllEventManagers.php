<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewEventManager;

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

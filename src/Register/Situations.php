<?php

namespace Imanghafoori\HeyMan\Register;

use Imanghafoori\HeyMan\Switching\Consider;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteSituations;
use Imanghafoori\HeyMan\WatchingStrategies\SituationsProxy;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewSituations;

class Situations
{
    public static function register(): void
    {
        Consider::$methods['eventChecks'] = EventManager::class;
        Consider::$methods['viewChecks'] = ViewEventManager::class;
        Consider::$methods['eloquentChecks'] = EloquentEventsManager::class;
        Consider::$methods['routeChecks'] = 'route';

        SituationsProxy::$situations[] = RouteSituations::class;
        SituationsProxy::$situations[] = EventSituations::class;
        SituationsProxy::$situations[] = EloquentSituations::class;
        SituationsProxy::$situations[] = ViewSituations::class;
    }
}
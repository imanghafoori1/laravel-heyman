<?php

namespace Imanghafoori\HeyMan\Register;

use Imanghafoori\HeyMan\Switching\Consider;
use Imanghafoori\HeyMan\WatchingStrategies\
{
    SituationsProxy,
    Events\EventManager,
    Views\ViewSituations,
    Routes\RouteEventManager,
    Views\ViewEventManager,
    EloquentModels\EloquentSituations,
    Events\EventSituations,
    Routes\RouteSituations,
    EloquentModels\EloquentEventsManager
};

class Situations
{
    public static function register(): void
    {
        Consider::$methods['eventChecks'] = EventManager::class;
        Consider::$methods['viewChecks'] = ViewEventManager::class;
        Consider::$methods['eloquentChecks'] = EloquentEventsManager::class;
        Consider::$methods['routeChecks'] = RouteEventManager::class;

        SituationsProxy::$situations[] = RouteSituations::class;
        SituationsProxy::$situations[] = EventSituations::class;
        SituationsProxy::$situations[] = EloquentSituations::class;
        SituationsProxy::$situations[] = ViewSituations::class;
    }
}

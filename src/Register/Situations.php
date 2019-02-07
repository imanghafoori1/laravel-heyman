<?php

namespace Imanghafoori\HeyMan\Register;

use Imanghafoori\HeyMan\Switching\Consider;
use Imanghafoori\HeyMan\WatchingStrategies\SituationsProxy;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventListeners;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewEventListener;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteEventListener;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentSituations;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentEventsListener;

class Situations
{
    public static function register(): void
    {
        Consider::$methods['eventChecks'] = EventListeners::class;
        SituationsProxy::$situations[] = EventSituations::class;

        Consider::$methods['eloquentChecks'] = EloquentEventsListener::class;
        SituationsProxy::$situations[] = EloquentSituations::class;

        Consider::$methods['routeChecks'] = RouteEventListener::class;
        SituationsProxy::$situations[] = RouteSituations::class;

        Consider::$methods['viewChecks'] = ViewEventListener::class;
        SituationsProxy::$situations[] = ViewSituations::class;
    }
}

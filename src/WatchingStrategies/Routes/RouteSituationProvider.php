<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

use Imanghafoori\HeyMan\Switching\Consider;
use Imanghafoori\HeyMan\WatchingStrategies\SituationsProxy;

class RouteSituationProvider
{
    public static function register(): void
    {
        Consider::$methods['routeChecks'] = RouteEventListener::class;
        SituationsProxy::$situations[] = RouteSituations::class;
    }
}

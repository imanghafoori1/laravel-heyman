<?php

namespace Imanghafoori\HeyMan\Register;

use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteSituations;
use Imanghafoori\HeyMan\WatchingStrategies\SituationsProxy;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewSituations;

class Situations
{
    public static function register(): void
    {
        SituationsProxy::$situations[] = RouteSituations::class;
        SituationsProxy::$situations[] = EventSituations::class;
        SituationsProxy::$situations[] = EloquentSituations::class;
        SituationsProxy::$situations[] = ViewSituations::class;
    }
}
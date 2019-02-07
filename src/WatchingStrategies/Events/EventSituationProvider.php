<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

use Imanghafoori\HeyMan\Switching\Consider;
use Imanghafoori\HeyMan\WatchingStrategies\SituationsProxy;

class EventSituationProvider
{
    public static function register(): void
    {
        Consider::$methods['eventChecks'] = EventListeners::class;
        SituationsProxy::$situations[] = EventSituations::class;
    }
}

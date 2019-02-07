<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

use Imanghafoori\HeyMan\Switching\Consider;
use Imanghafoori\HeyMan\WatchingStrategies\SituationsProxy;

class EloquentSituationProvider
{
    public static function register(): void
    {
        Consider::$methods['eloquentChecks'] = EloquentEventsListener::class;
        SituationsProxy::$situations[] = EloquentSituations::class;
    }
}

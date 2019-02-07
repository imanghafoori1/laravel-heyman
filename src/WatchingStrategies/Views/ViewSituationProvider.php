<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

use Imanghafoori\HeyMan\Switching\Consider;
use Imanghafoori\HeyMan\WatchingStrategies\SituationsProxy;


class ViewSituationProvider
{
    public static function register(): void
    {
        Consider::$methods['viewChecks'] = ViewEventListener::class;
        SituationsProxy::$situations[] = ViewSituations::class;
    }
}

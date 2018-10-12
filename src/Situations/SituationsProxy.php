<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewSituations;
use Imanghafoori\HeyMan\YouShouldHave;

final class SituationsProxy
{
    const situations = [
        RouteSituations::class,
        EloquentSituations::class,
        ViewSituations::class,
        EventSituations::class,
    ];

    public static function call($method, $args)
    {
        $args = is_array($args[0]) ? $args[0] : $args;
        foreach (self::situations as $className) {
            if (method_exists($className, $method) || resolve($className)->hasMethod($method)) {
                resolve($className)->$method(...$args);

                return resolve(YouShouldHave::class);
            }
        }
    }
}

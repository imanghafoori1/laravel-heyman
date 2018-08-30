<?php

namespace Imanghafoori\HeyMan\Situations;

class SituationsProxy
{
    const situations = [
        RouteSituations::class,
        ViewSituations::class,
        EloquentSituations::class,
        EventSituations::class,
    ];

    public static function call($method, $args)
    {
        foreach (self::situations as $className) {
            if (method_exists($className, $method)) {
                return app($className)->$method(...$args);
            }
        }
    }
}
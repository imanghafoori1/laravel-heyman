<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\YouShouldHave;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventSituations;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteSituations;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentSituations;

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
            if (self::methodExists($method, $className)) {
                resolve($className)->$method(...$args);

                return resolve(YouShouldHave::class);
            }
        }
    }

    /**
     * @param $method
     * @param $className
     *
     * @return bool
     */
    private static function methodExists($method, $className): bool
    {
        return method_exists($className, $method) || resolve($className)->hasMethod($method);
    }
}

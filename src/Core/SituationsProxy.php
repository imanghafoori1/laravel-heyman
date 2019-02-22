<?php

namespace Imanghafoori\HeyMan\Core;

use Imanghafoori\HeyMan\YouShouldHave;

final class SituationsProxy
{
    public static $situations = [];

    public static function call($method, $args)
    {
        $args = is_array($args[0]) ? $args[0] : $args;
        foreach (self::$situations as $className) {
            if (self::methodExists($method, $className)) {
                resolve($className)->$method(...$args);

                return resolve(YouShouldHave::class);
            }
        }
    }

    /**
     * @param string $method
     * @param string $className
     *
     * @return bool
     */
    private static function methodExists(string $method, string $className): bool
    {
        return method_exists($className, $method) || resolve($className)->hasMethod($method);
    }
}

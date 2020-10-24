<?php

namespace Imanghafoori\HeyMan\Core;

final class Situations
{
    private static $aliases = [];

    private static $methods = [];

    public static function add($listenerClass, $situation, $methods)
    {
        foreach ($methods as $method) {
            self::$methods[$method] = [$listenerClass, $situation];
        }
    }

    public static function call($method, $args)
    {
        $method = self::$aliases[$method] ?? $method;
        $args = is_array($args[0] ?? null) ? $args[0] : $args;
        [$listenerClass, $situation] = self::$methods[$method];

        resolve('heyman.chains')->init(
            $listenerClass, ...resolve($situation)->normalize($method, $args)
        );

        return resolve(Condition::class);
    }

    public static function aliasMethod($currentName, $newName)
    {
        self::$aliases[$newName] = $currentName;
    }
}

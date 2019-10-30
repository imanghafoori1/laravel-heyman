<?php

namespace Imanghafoori\HeyMan\Core;

final class Situations
{
    private static $methodAliases = [];

    private static $methods = [];

    public static function add($listenerClass, $situation, $methods)
    {
        foreach ($methods as $method) {
            self::$methods[$method] = [$listenerClass, $situation];
        }
    }

    public static function call($method, $args)
    {
        $method = self::$methodAliases[$method] ?? $method;
        $args = is_array($args[0]) ? $args[0] : $args;
        [$listenerClass, $situation] = self::$methods[$method];

        resolve('heyman.chains')->init(
            $listenerClass, ...resolve($situation)->normalize($method, $args)
        );

        return resolve(Condition::class);
    }

    public static function aliasMethod($currentName, $newName)
    {
        self::$methodAliases[$newName] = $currentName;
    }
}

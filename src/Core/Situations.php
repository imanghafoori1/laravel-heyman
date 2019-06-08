<?php

namespace Imanghafoori\HeyMan\Core;

use Imanghafoori\HeyMan\YouShouldHave;

final class Situations
{
    private static $methodAliases = [];

    private static $methods = [];

    public static function add($listenerClass, $situation, $methods): void
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

        return resolve(YouShouldHave::class);
    }

    public static function aliasMethod($currentName, $newName)
    {
        self::$methodAliases[$newName] = $currentName;
    }
}

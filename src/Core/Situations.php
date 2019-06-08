<?php

namespace Imanghafoori\HeyMan\Core;

use Imanghafoori\HeyMan\YouShouldHave;

final class Situations
{
    public static $situations = [];

    public static function add($listenerClass, $situation): void
    {
        self::$situations[$listenerClass] = $situation;
    }

    public static function call($method, $args)
    {
        $args = is_array($args[0]) ? $args[0] : $args;
        foreach (self::$situations as $listenerClass => $className) {
            if (in_array($method, resolve($className)->getMethods($method))) {
                $t = resolve($className);
                $r = $t->normalize($method, $args);
                resolve('heyman.chains')->init($listenerClass, ...$r);
                break;
            }
        }
        return resolve(YouShouldHave::class);
    }
}

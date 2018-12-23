<?php

namespace Imanghafoori\HeyMan\Switching;

final class HeyManSwitcher
{
    public function wrapForIgnorance(callable $callback, $key): \Closure
    {
        return function (...$args) use ($callback, $key) {
            if (! config('heyman_ignore_'.$key, false)) {
                $callback(...$args);
            }
        };
    }
}

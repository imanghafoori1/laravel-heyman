<?php

namespace Imanghafoori\HeyMan\Plugins\Conditions;

class Callbacks
{
    public function closureAllows($callback, $parameters = [])
    {
        return function (...$payload) use ($callback, $parameters) {
            return (bool) $callback(...array_merge($parameters, ...$payload));
        };
    }

    public function methodAllows($callback, array $parameters = [])
    {
        return function (...$payload) use ($callback, $parameters) {
            return (bool) app()->call($callback, array_merge($parameters, ...$payload));
        };
    }

    public function valueAllows($value)
    {
        return function () use ($value) {
            return (bool) $value;
        };
    }
}

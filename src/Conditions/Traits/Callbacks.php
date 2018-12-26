<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Callbacks
{
    public function closureAllows($callback, $parameters = [])
    {
        return $this->methodAllows($callback, $parameters);
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

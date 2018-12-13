<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Callbacks
{
    public function closureAllows($emptyString, $callback, $parameters = [])
    {
        // laravel bug :
        // it is not clear why laravel passes the $emptyString as the first parameter here.
        // check Imanghafoori\HeyMan\Conditions\ConditionsFacade class line 12;

        return $this->methodAllows($emptyString, $callback, $parameters);
    }

    public function methodAllows($emptyString, $callback, array $parameters = [])
    {
        // it is not clear why laravel passes the $emptyString as the first parameter here.
        // check Imanghafoori\HeyMan\Conditions\ConditionsFacade class line 12;

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

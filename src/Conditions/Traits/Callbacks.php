<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

trait Callbacks
{
    public function thisClosureShouldAllow(callable $callback, array $parameters = [])
    {
        return $this->thisMethodShouldAllow($callback, $parameters);
    }

    public function thisMethodShouldAllow($callback, array $parameters = [])
    {
        return function (...$payload) use ($callback, $parameters) {
            return (bool) app()->call($callback, array_merge($parameters, ...$payload));
        };
    }

    public function thisValueShouldAllow($value)
    {
        return function () use ($value) {
            return (bool) $value;
        };
    }
}

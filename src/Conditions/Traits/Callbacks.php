<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Callbacks
{
    public static function conditions()
    {
        $thisMethodShouldAllow = function ($callback, array $parameters = []) {
            return function (...$payload) use ($callback, $parameters) {
                return (bool) app()->call($callback, array_merge($parameters, ...$payload));
            };
        };

        return [
            'thisValueShouldAllow' => function ($value) {
                return function () use ($value) {
                    return (bool) $value;
                };
            },
            'thisMethodShouldAllow' => $thisMethodShouldAllow,
            'thisClosureShouldAllow' => function (callable $callback, array $parameters = []) use ($thisMethodShouldAllow) {
                return $thisMethodShouldAllow($callback, $parameters);
            },
        ];
    }
}

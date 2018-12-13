<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Session
{
    public static function conditions()
    {
        return [
            'sessionShouldHave' => function ($key) {
                return function () use ($key) {
                    return session()->has($key);
                };
            },
        ];
    }
}

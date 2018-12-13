<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Session
{
    public static function conditions($key)
    {
        return [
            'sessionShouldHave' => function () use ($key) {
                return session()->has($key);
            },
        ];
    }
}

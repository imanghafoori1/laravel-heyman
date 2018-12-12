<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Session
{
    public function conditions($key)
    {
        return [
            'sessionShouldHave' => function () use ($key) {
                return session()->has($key);
            },
        ];
    }
}

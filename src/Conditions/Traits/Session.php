<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Session
{
    public function sessionHas($key)
    {
        return function () use ($key) {
            return session()->has($key);
        };
    }
}

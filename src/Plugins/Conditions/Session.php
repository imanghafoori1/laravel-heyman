<?php

namespace Imanghafoori\HeyMan\Plugins\Conditions;

class Session
{
    public function sessionHas($key)
    {
        return function () use ($key) {
            return session()->has($key);
        };
    }
}

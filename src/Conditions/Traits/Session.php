<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

trait Session
{
    public function sessionShouldHave($key)
    {
        return function () use ($key) {
            return session()->has($key);
        };
    }
}

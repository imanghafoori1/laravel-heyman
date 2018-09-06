<?php

namespace Imanghafoori\HeyMan\Conditions;

trait Authentication
{
    public function youShouldBeGuest($guard = null)
    {
        return function () use ($guard) {
            return auth($guard)->guest();
        };
    }

    public function youShouldBeLoggedIn($guard = null)
    {
        return function () use ($guard) {
            return auth($guard)->check();
        };
    }
}
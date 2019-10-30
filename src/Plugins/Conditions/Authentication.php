<?php

namespace Imanghafoori\HeyMan\Plugins\Conditions;

class Authentication
{
    public function beGuest($guard = null)
    {
        return function () use ($guard) {
            return auth($guard)->guest();
        };
    }

    public function loggedIn($guard = null)
    {
        return function () use ($guard) {
            return auth($guard)->check();
        };
    }
}

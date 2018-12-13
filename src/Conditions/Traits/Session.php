<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

use Imanghafoori\HeyMan\Conditions\ConditionsFacade;

class Session
{
    public static function conditions(ConditionsFacade $cFacade)
    {
        $cFacade->define('sessionShouldHave', function ($key) {
            return function () use ($key) {
                return session()->has($key);
            };
        });
    }
}

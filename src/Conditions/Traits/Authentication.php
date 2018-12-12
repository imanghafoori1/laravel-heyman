<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

class Authentication
{
    public static function conditions()
    {
        return [
           'youShouldBeGuest' => function ($guard = null) {
               return function () use ($guard) {
                   return auth($guard)->guest();
               };
           },

           'youShouldBeLoggedIn' => function ($guard = null) {
               return function () use ($guard) {
                   return auth($guard)->check();
               };
           },
       ];
    }
}

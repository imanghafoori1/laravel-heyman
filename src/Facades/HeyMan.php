<?php

namespace Imanghafoori\HeyMan\Facades;

use Illuminate\Support\Facades\Facade;

class HeyMan extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'hey_man';
    }
}
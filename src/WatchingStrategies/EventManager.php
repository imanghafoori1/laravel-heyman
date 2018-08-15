<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Facades\Event;

class EventManager extends BaseManager
{
    protected $initial;

    protected $type = 'event';

    public function register($event, $callback)
    {
        Event::listen($event, $callback[0]);
    }
}

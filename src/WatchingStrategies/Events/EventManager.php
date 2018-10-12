<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

use Imanghafoori\HeyMan\WatchingStrategies\BaseManager;

class EventManager extends BaseManager
{
    public function register($event, array $callback)
    {
        \Event::listen($event, $callback[0]);
    }
}

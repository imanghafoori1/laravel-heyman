<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

class EventManager
{
    public function register($event, array $callback)
    {
        \Event::listen($event, $callback[0]);
    }
}

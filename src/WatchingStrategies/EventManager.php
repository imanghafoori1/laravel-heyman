<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class EventManager extends BaseManager
{
    public function register($event, array $callback, string $method)
    {
        \Event::$method($event, $callback[0]);
    }
}

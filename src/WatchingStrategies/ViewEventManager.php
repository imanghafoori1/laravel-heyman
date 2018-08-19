<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class ViewEventManager extends BaseManager
{
    public function register(string $view, array $callback, string $event)
    {
        view()->$event($view, $callback[0]);
    }
}

<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class ViewEventManager extends BaseManager
{
    public function register(string $view, array $callback)
    {
        view()->creator($view, $callback[0]);
    }
}

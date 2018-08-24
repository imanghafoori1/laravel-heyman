<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class ViewEventManager extends BaseManager
{
    /**
     * @param string $view
     * @param array  $callback
     */
    public function register(string $view, array $callback)
    {
        view()->creator($view, $callback[0]);
    }
}

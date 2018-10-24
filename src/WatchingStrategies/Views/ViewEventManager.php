<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

class ViewEventManager
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

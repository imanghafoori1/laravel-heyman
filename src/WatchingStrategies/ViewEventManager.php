<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class ViewEventManager
{
    private $views;

    /**
     * ViewEventManager constructor.
     *
     * @param $views
     * @return \Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager
     */
    public function init($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        $callback = function (...$args) use ($callback) {
            if (! config('heyman_ignore_view', false)) {
                $callback(...$args);
            }
        };

        foreach ($this->views as $view) {
            view()->creator($view, $callback);
        }
    }
}

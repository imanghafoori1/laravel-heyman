<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class ViewEventManager
{
    private $views = [];

    /**
     * ViewEventManager constructor.
     *
     * @param $views
     *
     * @return ViewEventManager
     */
    public function init(array $views): ViewEventManager
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @param $listner
     */
    public function startGuarding(callable $listner)
    {
        foreach ($this->views as $view) {
            view()->creator($view, $this->wrapForIgnorance($listner));
        }
    }

    private function wrapForIgnorance(callable $callback): callable
    {
        return function (...$args) use ($callback) {
            if (! config('heyman_ignore_view', false)) {
                $callback(...$args);
            }
        };
    }
}

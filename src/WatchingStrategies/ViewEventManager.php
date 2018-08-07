<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\HeyManSwitcher;

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
    public function init(array $views): self
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @param $listener
     */
    public function startGuarding(callable $listener)
    {
        $switchableListener = app(HeyManSwitcher::class)->wrapForIgnorance($listener, 'view');
        foreach ($this->views as $view) {
            view()->creator($view, $switchableListener);
        }
    }
}

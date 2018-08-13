<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\HeyManSwitcher;

class ViewEventManager
{
    private $views = [];

    private $data = [];

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
        $views = $this->views;
        $this->data[] = [$views, $switchableListener];


    }

    public function start()
    {
        foreach ($this->data as $data) {
            foreach ($data[0] as $view) {
                view()->creator($view, $data[1]);
            }
        }

    }
}

<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\HeyManSwitcher;

class EloquentEventsManager
{
    private $event;

    private $modelClass;

    /**
     * EloquentEventsManager constructor.
     *
     * @param $event
     * @param $modelClass
     *
     * @return EloquentEventsManager
     */
    public function init(string $event, array $modelClass) : self
    {
        $this->event = $event;
        $this->modelClass = $modelClass;

        return $this;
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        $callback = app(HeyManSwitcher::class)->wrapForIgnorance($callback, 'eloquent');
        foreach ($this->modelClass as $model) {
            $model::{$this->event}($callback);
        }
    }
}

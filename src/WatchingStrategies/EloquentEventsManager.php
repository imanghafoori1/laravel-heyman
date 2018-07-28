<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

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
     * @return \Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager
     */
    public function init($event, $modelClass)
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
        $c = function (...$args) use ($callback) {
            if (!config('heyman_ignore_eloquent', false)) {
                $callback(...$args);
            }
        };

        foreach ($this->modelClass as $model) {
            $model::{$this->event}($c);
        }
    }
}

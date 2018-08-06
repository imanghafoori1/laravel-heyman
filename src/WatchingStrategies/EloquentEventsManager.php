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
        $callback = $this->wrapForIgnorance($callback);

        foreach ($this->modelClass as $model) {
            $model::{$this->event}($callback);
        }
    }

    /**
     * @param callable $callback
     *
     * @return \Closure
     */
    private function wrapForIgnorance(callable $callback): \Closure
    {
        return function (...$args) use ($callback) {
            if (!config('heyman_ignore_eloquent', false)) {
                $callback(...$args);
            }
        };
    }
}

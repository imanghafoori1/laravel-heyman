<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Facades\Event;

class BasicEventManager
{
    private $events;

    /**
     * BasicEventManager constructor.
     *
     * @param $events
     *
     * @return BasicEventManager
     */
    public function init(array $events): self
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @param $listener
     */
    public function startGuarding(callable $listener)
    {
        Event::listen($this->events, $this->wrapForIgnorance($listener));
    }

    /**
     * @param callable $callback
     *
     * @return \Closure
     */
    private function wrapForIgnorance(callable $callback): \Closure
    {
        return function () use ($callback) {
            if (!config('heyman_ignore_event', false)) {
                $callback();
            }
        };
    }
}

<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Facades\Event;

class BasicEventManager
{
    private $events;

    /**
     * BasicEventManager constructor.
     *
     * @param $event
     *
     * @return \Imanghafoori\HeyMan\WatchingStrategies\BasicEventManager
     */
    public function init($event)
    {
        $this->events = $event;

        return $this;
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        $listener = function () use ($callback) {
            if (!config('heyman_ignore_event', false)) {
                $callback();
            }
        };
        Event::listen($this->events, $listener);
        $this->events = [];
    }
}

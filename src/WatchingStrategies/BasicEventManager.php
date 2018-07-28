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
        Event::listen($this->events, $callback);
        $this->events = [];
    }
}

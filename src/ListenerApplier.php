<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Event;

class ListenerApplier
{
    private $events;

    /**
     * ConditionApplier constructor.
     *
     * @param $event
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

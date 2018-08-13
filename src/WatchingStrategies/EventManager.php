<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Facades\Event;
use Imanghafoori\HeyMan\HeyManSwitcher;

class EventManager
{
    private $events;

    private $data = [];

    /**
     * BasicEventManager constructor.
     *
     * @param $events
     *
     * @return EventManager
     */
    public function init(array $events): self
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @param $listener
     */
    public function commitChain(callable $listener)
    {
        $r = $this->events;
        $t = app(HeyManSwitcher::class)->wrapForIgnorance($listener, 'event');

        $this->data[] = [$r, $t];
    }

    public function start()
    {
        foreach ($this->data as $data) {
            Event::listen(...$data);
        }
    }
}

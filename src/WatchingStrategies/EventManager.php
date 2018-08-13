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
        $t = app(HeyManSwitcher::class)->wrapForIgnorance($listener, 'event');

        $this->data[] = [$this->events, $t];
    }

    public function start()
    {
        foreach ($this->data as $data) {
            Event::listen(...$data);
        }
    }

    public function forgetAbout($events)
    {
        foreach ($events as $event) {
            foreach ($this->data as $i => $data) {
                if (($key = array_search($event, $data[0])) !== false) {
                    unset($this->data[$i][0][$key]);
                }
            }
        }
    }
}

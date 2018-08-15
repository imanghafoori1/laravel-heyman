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

        foreach ($this->events as $event) {
            $this->data[$event][] = $t;
        }
    }

    public function start()
    {
        foreach ($this->data as $value => $callbacks) {
            foreach ($callbacks as $cb) {
                $this->register($value, $cb);
            }
        }
    }

    public function forgetAbout($events)
    {
        foreach ($events as $event) {
            unset($this->data[$event]);
        }
    }

    public function register($event, $callback)
    {
        Event::listen($event,$callback);
    }
}

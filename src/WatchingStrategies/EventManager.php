<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Facades\Event;
use Imanghafoori\HeyMan\HeyManSwitcher;

class EventManager
{
    private $initial;

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
        $this->initial = $events;

        return $this;
    }

    /**
     * @param callable $callback
     */
    public function commitChain(callable $callback)
    {
        $t = app(HeyManSwitcher::class)->wrapForIgnorance($callback, 'event');

        foreach ($this->initial as $event) {
            $this->data[$event][] = $t;
        }
    }

    public function start()
    {
        foreach ($this->data as $value => $callbacks) {
            foreach ($callbacks as $key => $cb) {
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

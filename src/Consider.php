<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager;
use Imanghafoori\HeyMan\WatchingStrategies\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;

class Consider
{
    private $mode;

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function eloquentChecks(callable $closure = null)
    {
        return $this->turn(EloquentEventsManager::class, $closure);
    }

    public function viewChecks(callable $closure = null)
    {
        return $this->turn(ViewEventManager::class, $closure);
    }

    public function routeChecks(callable $closure = null)
    {
        return $this->turn(RouterEventManager::class, $closure);
    }

    public function eventChecks(callable $closure = null)
    {
        return $this->turn(EventManager::class, $closure);
    }

    public function validationChecks(callable $closure = null)
    {
        return $this->turn('validation', $closure);
    }

    public function allChecks()
    {
        $this->validationChecks();
        $this->eventChecks();
        $this->eloquentChecks();
        $this->routeChecks();
        $this->viewChecks();
    }

    /**
     * @param $key
     * @param callable|null $closure
     */
    private function turn($key, callable $closure = null)
    {
        $key = 'heyman_ignore_'.$key;

        $current = config($key);
        config()->set($key, [
            'turnOff' => true,
            'turnOn'  => false,
        ][$this->mode]);

        if (is_null($closure)) {
            return;
        }
        $result = $closure();
        config()->set($key, $current);

        return $result;
    }
}

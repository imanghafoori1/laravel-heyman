<?php

namespace Imanghafoori\HeyMan;

class Consider
{
    private $mode;

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function eloquentChecks(callable $closure = null)
    {
        return $this->turn('heyman_ignore_eloquent', $closure);
    }

    public function viewChecks(callable $closure = null)
    {
        return $this->turn('heyman_ignore_view', $closure);
    }

    public function routeChecks(callable $closure = null)
    {
        return $this->turn('heyman_ignore_route', $closure);
    }

    public function eventChecks(callable $closure = null)
    {
        return $this->turn('heyman_ignore_event', $closure);
    }

    public function validationChecks(callable $closure = null)
    {
        return $this->turn('heyman_ignore_validation', $closure);
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

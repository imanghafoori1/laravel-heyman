<?php

namespace Imanghafoori\HeyMan;

class Consider
{
    private $mode;

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function eloquentChecks()
    {
        $this->ignore('heyman_ignore_eloquent');
    }

    public function viewChecks()
    {
        $this->ignore('heyman_ignore_view');
    }

    public function routeChecks()
    {
        $this->ignore('heyman_ignore_route');
    }

    public function eventChecks()
    {
        $this->ignore('heyman_ignore_event');
    }

    public function allChecks()
    {
        $this->eventChecks();
        $this->eloquentChecks();
        $this->routeChecks();
        $this->viewChecks();
    }

    /**
     * @param $key
     */
    private function ignore($key)
    {
        config()->set($key, [
            'turnOff' => true,
            'turnOn'  => false,
        ][$this->mode]);
    }
}

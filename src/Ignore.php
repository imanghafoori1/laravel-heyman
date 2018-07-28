<?php

namespace Imanghafoori\HeyMan;

class Ignore
{
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
    
    /**
     * @param $key
     */
    private function ignore($key)
    {
        config()->set($key, true);
    }
}
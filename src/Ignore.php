<?php

namespace Imanghafoori\HeyMan;

class Ignore
{
    public function eloquentChecks()
    {
        config()->set('heyman_ignore_eloquent', true);
    }

    public function viewChecks()
    {
        config()->set('heyman_ignore_view', true);
    }

    public function routeChecks()
    {
        config()->set('heyman_ignore_route', true);
    }

    public function eventChecks()
    {
        config()->set('heyman_ignore_event', true);
    }
}
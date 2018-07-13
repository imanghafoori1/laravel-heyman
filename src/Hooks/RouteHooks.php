<?php

namespace Imanghafoori\HeyMan\Hooks;

trait RouteHooks
{
    public function whenVisitingUrl(...$url)
    {
        return $this->authorizeRoute('urls', $url);
    }

    public function whenVisitingRoute(...$routeName)
    {
        return $this->authorizeRoute('routeNames', $routeName);
    }

    public function whenCallingAction(...$action)
    {
        return $this->authorizeRoute('actions', $action);
    }

    private function authorizeRoute($target, $value)
    {
        $this->authorizer = app('hey_man_route_authorizer')->init($target, $this->normalizeInput($value));
        return app('hey_man_you_should_have');
    }
}
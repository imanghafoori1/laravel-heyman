<?php

namespace Imanghafoori\HeyMan\Hooks;

trait RouteHooks
{
    public function whenYouVisitUrl(...$url)
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
        return app(\Imanghafoori\HeyMan\YouShouldHave::class);
    }
}
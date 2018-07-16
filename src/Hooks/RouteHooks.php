<?php

namespace Imanghafoori\HeyMan\Hooks;

trait RouteHooks
{
    public function whenYouVisitUrl(...$url)
    {
        $removeSlash = function ($url) {
            return ltrim($url, "/");
        };

        $url = array_map($removeSlash, $this->normalizeInput($url));

        return $this->authorizeRoute('urls', $url);
    }

    public function whenYouVisitRoute(...$routeName)
    {
        return $this->authorizeRoute('routeNames', $routeName);
    }

    public function whenYouCallAction(...$action)
    {
        return $this->authorizeRoute('actions', $action);
    }

    private function authorizeRoute($target, $value)
    {
        $this->authorizer = app('hey_man_route_authorizer')->init($target, $this->normalizeInput($value));
        return app(\Imanghafoori\HeyMan\YouShouldHave::class);
    }
}
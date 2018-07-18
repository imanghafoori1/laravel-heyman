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
        return $this->authorizeRoute('routeNames', $this->normalizeInput($routeName));
    }

    public function whenYouCallAction(...$action)
    {
        $addNamespace = function ($action) {
            if ($action = ltrim($action, '\\')) {
                return $action;
            }
            return app()->getNamespace().'\\Http\\Controllers\\'.$action;
        };

        $action = array_map($addNamespace, $this->normalizeInput($action));

        return $this->authorizeRoute('actions', $action);
    }

    private function authorizeRoute($target, $value)
    {
        $this->authorizer = app('hey_man_route_authorizer')->init($target, $value);
        return app(\Imanghafoori\HeyMan\YouShouldHave::class);
    }
}
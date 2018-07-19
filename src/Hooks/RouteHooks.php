<?php

namespace Imanghafoori\HeyMan\Hooks;

use Imanghafoori\HeyMan\YouShouldHave;

trait RouteHooks
{
    /**
     * @param mixed ...$url
     * @return YouShouldHave
     */
    public function whenYouVisitUrl(...$url)
    {
        $removeSlash = function ($url) {
            return ltrim($url, "/");
        };

        $url = array_map($removeSlash, $this->normalizeInput($url));

        return $this->authorizeRoute('urls', $url);
    }

    /**
     * @param mixed ...$routeName
     * @return YouShouldHave
     */
    public function whenYouVisitRoute(...$routeName)
    {
        return $this->authorizeRoute('routeNames', $this->normalizeInput($routeName));
    }

    /**
     * @param mixed ...$action
     * @return YouShouldHave
     */
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
    /**
     * @param $target
     * @param $value
     * @return YouShouldHave
     */
    private function authorizeRoute($target, $value)
    {
        $this->authorizer = app('hey_man_route_authorizer')->init($target, $value);

        return app(YouShouldHave::class);
    }
}
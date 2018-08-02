<?php

namespace Imanghafoori\HeyMan\Hooks;

use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;
use Imanghafoori\HeyMan\YouShouldHave;

trait RouteHooks
{
    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouVisitUrl(...$url)
    {
        return $this->authorizeURL($url, 'GET');
    }

    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouSendPost(...$url)
    {
        return $this->authorizeURL($url, 'POST');
    }

    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouSendPatch(...$url)
    {
        return $this->authorizeURL($url, 'PATCH');
    }

    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouSendPut(...$url)
    {
        return $this->authorizeURL($url, 'PUT');
    }

    /**
     * @param mixed ...$url
     *
     * @return YouShouldHave
     */
    public function whenYouSendDelete(...$url)
    {
        return $this->authorizeURL($url, 'DELETE');
    }

    /**
     * @param mixed ...$routeName
     *
     * @return YouShouldHave
     */
    public function whenYouReachRoute(...$routeName)
    {
        return $this->authorizeRoute('routeNames', $this->normalizeInput($routeName));
    }

    /**
     * @param mixed ...$action
     *
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
     *
     * @return YouShouldHave
     */
    private function authorizeRoute($target, $value)
    {
        $this->chain->eventManager = app(RouterEventManager::class)->init($target, $value);

        return app(YouShouldHave::class);
    }

    /**
     * @param $url
     * @param $verb
     * @return \Imanghafoori\HeyMan\YouShouldHave
     */
    private function authorizeURL($url, $verb): \Imanghafoori\HeyMan\YouShouldHave
    {
        $removeSlash = function ($url) use ($verb) {
            return $verb.ltrim($url, '/');
        };

        $url = array_map($removeSlash, $this->normalizeInput($url));

        return $this->authorizeRoute('urls', $url);
    }
}

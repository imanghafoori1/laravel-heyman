<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Str;

class RouterEventManager
{
    private $routeInfo;

    private $all = [];

    public function findMatchingCallbacks($matchedRoute)
    {
        $output = [];
        foreach ($this->all as $routeInfo => $callBacks) {
            foreach ($matchedRoute as $info) {
                if (Str::is($routeInfo, $info)) {
                    $output[] = $this->wrapCallbacksForIgnore($callBacks);
                }
            }
        }

        return $output;
    }

    /**
     * RouterEventManager constructor.
     *
     * @param $target
     * @param $routeInfo
     *
     * @return \Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager
     */
    public function init($routeInfo)
    {
        $this->routeInfo = $routeInfo;

        return $this;
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        foreach ($this->routeInfo as $routeInfo) {
            $this->all[$routeInfo][] = $callback;
        }
    }

    /**
     * @param $callbacks
     *
     * @return array
     */
    private function wrapCallbacksForIgnore($callbacks): array
    {
        return array_map(function ($callback) {
            return function () use ($callback) {
                if (!config('heyman_ignore_route', false)) {
                    $callback();
                }
            };
        }, $callbacks);
    }
}

<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Str;

class RouterEventManager
{
    private $routeInfo;

    private $routeChains = [];

    public function findMatchingCallbacks($matchedRoute)
    {
        $matchedCallbacks = [];
        foreach ($this->routeChains as $routeInfo => $callBacks) {
            foreach ($matchedRoute as $info) {
                if (Str::is($routeInfo, $info)) {
                    $matchedCallbacks[] = $this->wrapCallbacksForIgnore($callBacks);
                }
            }
        }

        return $matchedCallbacks;
    }

    /**
     * RouterEventManager constructor.
     *
     * @param $routeInfo
     *
     * @return RouterEventManager
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
            $this->routeChains[$routeInfo][] = $callback;
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

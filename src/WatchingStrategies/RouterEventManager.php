<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Str;

class RouterEventManager
{
    private $routeInfo;

    private $routeChains = [];

    public function findMatchingCallbacks(array $matchedRoute): array
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
     * @param $callbacks
     *
     * @return array
     */
    private function wrapCallbacksForIgnore(array $callbacks): array
    {
        return array_map(function ($callback) {
            return $this->wrapForIgnorance($callback);
        }, $callbacks);
    }

    /**
     * RouterEventManager constructor.
     *
     * @param $routeInfo
     *
     * @return RouterEventManager
     */
    public function init($routeInfo): RouterEventManager
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

    private function wrapForIgnorance(callable $callback): callable
    {
        return function () use ($callback) {
            if (! config('heyman_ignore_route', false)) {
                $callback();
            }
        };
    }
}

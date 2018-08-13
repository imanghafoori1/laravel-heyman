<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Str;
use Imanghafoori\HeyMan\HeyManSwitcher;

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
            return app(HeyManSwitcher::class)->wrapForIgnorance($callback, 'route');
        }, $callbacks);
    }

    /**
     * RouterEventManager constructor.
     *
     * @param $routeInfo
     *
     * @return RouterEventManager
     */
    public function init(array $routeInfo): self
    {
        $this->routeInfo = $routeInfo;

        return $this;
    }

    /**
     * @param $callback
     */
    public function commitChain(callable $callback)
    {
        foreach ($this->routeInfo as $routeInfo) {
            $this->routeChains[$routeInfo][] = $callback;
        }
    }

    public function forgetAbout($routeInfos)
    {
        foreach ($routeInfos as $routeInfo) {
            unset($this->routeChains[$routeInfo]);
        }
    }
}

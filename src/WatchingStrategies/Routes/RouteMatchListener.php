<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

use Illuminate\Support\Str;

final class RouteMatchListener
{
    /**
     * @param array $closures
     */
    private function exec(array $closures)
    {
        foreach (array_flatten($closures) as $closure) {
            $closure();
        }
    }

    /**
     * @param array $matchedRoute Information about the currently matched route
     * @param $chainData
     *
     * @return void
     */
    public function execMatchedCallbacks(array $matchedRoute, $chainData)
    {
        $matchedCallbacks = [];
        foreach (array_filter($matchedRoute) as $info) {
            foreach ($chainData as $routeInfo => $callBacks) {
                if (Str::is($routeInfo, $info)) {
                    $matchedCallbacks[] = array_pop($callBacks);
                }
            }
        }

        $this->exec($matchedCallbacks);
    }
}

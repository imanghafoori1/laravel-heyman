<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Events\RouteMatched;

final class RouteEventListener
{
    /**
     * @param $chainData
     *
     * @return void
     */
    public function startWatching($chainData)
    {
        Route::matched(function (RouteMatched $eventObj) use ($chainData) {
            $matchedRoute = $this->getMatchedRouteInto($eventObj);
            $matchedCallbacks = [];
            foreach ($matchedRoute as $info) {
                foreach ($chainData as $routeInfo => $callBacks) {
                    if (Str::is($routeInfo, $info)) {
                        $matchedCallbacks[] = array_pop($callBacks);
                    }
                }
            }

            $this->exec($matchedCallbacks);
        });
    }

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
     * @param \Illuminate\Routing\Events\RouteMatched $eventObj
     * @return array
     */
    public function getMatchedRouteInto(RouteMatched $eventObj): array
    {
        $matchedRoute = [
            $eventObj->route->getName(),
            $eventObj->route->getActionName(),
            $eventObj->request->method().$eventObj->route->uri,
        ];

        return array_filter($matchedRoute);
    }
}

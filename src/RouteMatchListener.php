<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager;

class RouteAuthorizer
{
    public function authorizeMatchedRoutes()
    {
        Route::matched(function (RouteMatched $eventObj) {
            $matchedRoute = [
                $eventObj->route->getName(),
                $eventObj->route->getActionName(),
                $eventObj->request->method().$eventObj->route->uri,
            ];

            $closures = app(RouterEventManager::class)->findMatchingCallbacks($matchedRoute);
            $this->performClosures($closures);
        });
    }

    /**
     * @param $closures
     */
    private function performClosures($closures)
    {
        foreach ($closures as $closure) {
            foreach ($closure as $c) {
                $c();
            }
        }
    }
}

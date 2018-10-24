<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

class RouterEventManager
{
    public function start()
    {
        Route::matched(function (RouteMatched $eventObj) {
            $matchedRoute = [
                $eventObj->route->getName(),
                $eventObj->route->getActionName(),
                $eventObj->request->method().$eventObj->route->uri,
            ];

            $t = resolve('BaseManager')->data['Imanghafoori\HeyMan\WatchingStrategies\Routes\RouterEventManager'] ?? [];
            resolve(RouteMatchListener::class)->execMatchedCallbacks($matchedRoute, $t);
        });
    }
}

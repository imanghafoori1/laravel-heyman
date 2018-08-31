<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\RouteMatchListener;

class RouterEventManager extends BaseManager
{
    public function start()
    {
        Route::matched(function (RouteMatched $eventObj) {
            $matchedRoute = [
                $eventObj->route->getName(),
                $eventObj->route->getActionName(),
                $eventObj->request->method().$eventObj->route->uri,
            ];

            resolve(RouteMatchListener::class)->execMatchedCallbacks($matchedRoute, $this->data);
        });
    }
}

<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Routes;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

final class RouteEventListener
{
    public function startWatching($chainData)
    {
        MatchedRoute::$chainData = $chainData;
        Route::matched(function (RouteMatched $eventObj) {
            $eventObj->route->middleware(MatchedRoute::class);
        });
    }
}

<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Routes;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Contracts\HeymanSentinel;

final class RouteEventListener implements HeymanSentinel
{
    public function startWatching($chainData)
    {
        MatchedRoute::$chainData = $chainData;
        Route::matched(function (RouteMatched $eventObj) {
            $eventObj->route->middleware(MatchedRoute::class);
        });
    }
}

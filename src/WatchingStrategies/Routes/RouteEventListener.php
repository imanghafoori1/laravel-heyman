<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

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
        MatchedRoute::$chainData = $chainData;
        Route::matched(function (RouteMatched $eventObj) {
            $eventObj->route->middleware(MatchedRoute::class);
        });
    }
}

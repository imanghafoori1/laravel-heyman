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
            $route = $eventObj->route;
            $this->setGuardFor($eventObj->request->method().$route->uri);
            $this->setGuardFor($route->getName());
            $this->setGuardFor($route->getActionName());
        });
    }

    /**
     * @param $url
     */
    private function setGuardFor($url)
    {
        $closures = app(RouterEventManager::class)->resolveCallbacks($url);
        foreach ($closures as $cb) {
            $cb();
        }
    }
}

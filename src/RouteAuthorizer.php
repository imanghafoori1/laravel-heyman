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
            if ($eventObj->request->method() === 'GET') {
                $this->authorizeUrls($route->uri);
            }
            $this->authorizeRouteNames($route->getName());
            $this->authorizeRouteActions($route->getActionName());
        });
    }

    /**
     * @param $actionName
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeRouteActions($actionName)
    {
        $this->setGuardFor('Actions', $actionName);
    }

    /**
     * @param $routeName
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeRouteNames($routeName)
    {
        $this->setGuardFor('RouteNames', $routeName);
    }

    /**
     * @param $url
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeUrls($url)
    {
        $this->setGuardFor('Urls', $url);
    }

    /**
     * @param $method
     * @param $key
     */
    private function setGuardFor($method, $key)
    {
        $method = 'get'.$method;
        app(RouterEventManager::class)->{$method}($key)();
    }
}

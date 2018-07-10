<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

class RouteAuthorizer
{
    public function authorizeMatchedRoutes(): void
    {
        Route::matched(function (RouteMatched $eventObj){
            $this->authorizeUrls($eventObj);
            $this->authorizeRouteNames($eventObj);
            $this->authorizeRouteActions($eventObj);
        });
    }
    /**
     * @param \Illuminate\Routing\Events\RouteMatched $eventObj
     */
    private function authorizeRouteActions(RouteMatched $eventObj)
    {
        $actions = app('hey_man_authorizer')->getActions();
        $currentActionName = $eventObj->route->getActionName();

        if (isset($actions[$currentActionName]['role'])) {
            if (! auth()->user()->hasRole($actions[$currentActionName]['role'])) {
                $this->denyAccess();
            }
        }
    }

    /**
     * @param \Illuminate\Routing\Events\RouteMatched $eventObj
     */
    private function authorizeRouteNames(RouteMatched $eventObj)
    {
        $routeNames = app('hey_man_authorizer')->getRouteNames();
        $currentRouteName = $eventObj->route->getName();

        if (isset($routeNames[$currentRouteName]['role'])) {
            if (! auth()->user()->hasRole($routeNames[$currentRouteName]['role'])) {
                $this->denyAccess();
            }
        }
    }

    /**
     * @param \Illuminate\Routing\Events\RouteMatched $eventObj
     */
    function authorizeUrls(RouteMatched $eventObj)
    {
        $currentUrl = $eventObj->route->uri;
        $urls = app('hey_man_authorizer')->getUrls();

        if (isset($urls[$currentUrl]['role'])) {
            if (! auth()->user()->hasRole($urls[$currentUrl]['role'])) {
                $this->denyAccess();
            }
        }
    }

    private function denyAccess()
    {
        throw new AuthorizationException();
    }
}
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
            $this->authorizeUrls($eventObj->route->uri);
            $this->authorizeRouteNames($eventObj->route->getName());
            $this->authorizeRouteActions($eventObj->route->getActionName());
        });
    }

    /**
     * @param $currentActionName
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeRouteActions($currentActionName)
    {
        $actions = app('hey_man_authorizer')->getActions();

        if (isset($actions[$currentActionName]['role'])) {
            if (! auth()->user()->hasRole($actions[$currentActionName]['role'])) {
                $this->denyAccess();
            }
        }
    }

    /**
     * @param $currentRouteName
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeRouteNames($currentRouteName)
    {
        $routeNames = app('hey_man_authorizer')->getRouteNames();

        if (isset($routeNames[$currentRouteName]['role'])) {
            if (! auth()->user()->hasRole($routeNames[$currentRouteName]['role'])) {
                $this->denyAccess();
            }
        }
    }

    /**
     * @param $currentUrl
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    function authorizeUrls($currentUrl)
    {
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
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
        $actions = app('hey_man_authorizer')->getActions($currentActionName);

        if ($actions) {
            $this->checkAccess($actions);
        }
    }

    /**
     * @param $currentRouteName
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeRouteNames($currentRouteName)
    {
        $routeName = app('hey_man_authorizer')->getRouteNames($currentRouteName);

        if ($routeName) {
            $this->checkAccess($routeName);
        }
    }

    /**
     * @param $currentUrl
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    function authorizeUrls($currentUrl)
    {
        $urls = app('hey_man_authorizer')->getUrls($currentUrl);

        if ($urls) {
            $this->checkAccess($urls);
        }
    }

    private function denyAccess()
    {
        throw new AuthorizationException();
    }

    /**
     * @param $role
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function checkAccess($role)
    {
        if (! auth()->user()->hasRole($role)) {
            $this->denyAccess();
        }
    }
}
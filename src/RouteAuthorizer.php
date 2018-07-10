<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

class RouteAuthorizer
{
    public function authorizeMatchedRoutes(): void
    {
        Route::matched(function (RouteMatched $eventObj) {
            $route = $eventObj->route;
            $this->authorizeUrls($route->uri);
            $this->authorizeRouteNames($route->getName());
            $this->authorizeRouteActions($route->getActionName());
        });
    }

    /**
     * @param $actionName
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeRouteActions($actionName)
    {
        $this->setGuardFor('Actions', $actionName);
    }

    /**
     * @param $routeName
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeRouteNames($routeName)
    {
        $this->setGuardFor('RouteNames', $routeName);
    }

    /**
     * @param $url
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    function authorizeUrls($url)
    {
        $this->setGuardFor('Urls', $url);
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

    /**
     * @param $currentUrl
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function setGuardFor($method, $key)
    {
        $method = 'get'.$method;
        $value = app('hey_man_authorizer')->{$method}($key);

        if ($value) {
            $this->checkAccess($value);
        }
    }
}
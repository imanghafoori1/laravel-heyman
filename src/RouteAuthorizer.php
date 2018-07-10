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
        $this->setGuardFor('Actions', $currentActionName);
    }

    /**
     * @param $currentRouteName
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function authorizeRouteNames($currentRouteName)
    {
        $this->setGuardFor('RouteNames', $currentRouteName);
    }

    /**
     * @param $currentUrl
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    function authorizeUrls($currentUrl)
    {
        $this->setGuardFor('Urls', $currentUrl);
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
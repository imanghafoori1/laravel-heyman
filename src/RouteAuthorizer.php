<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

class RouteAuthorizer
{
    public function authorizeMatchedRoutes($app): void
    {
        Route::matched(function (RouteMatched $eventObj) use($app) {
            $currentUrl = $eventObj->route->uri;
            $urls = $app['hey_man']->getUrls();

            if (isset($urls[$currentUrl]['role'])) {
                if (! auth()->user()->hasRole($urls[$currentUrl]['role'])) {
                    throw new AuthorizationException();
                }
            }

            $routeNames = $app['hey_man']->getRouteNames();
            $currentRouteName = $eventObj->route->getName();

            if (isset($routeNames[$currentRouteName]['role'])) {
                if (! auth()->user()->hasRole($routeNames[$currentRouteName]['role'])) {
                    throw new AuthorizationException();
                }
            }

            $actions = $app['hey_man']->getActions();
            $currentActionName = $eventObj->route->getActionName();

            if (isset($actions[$currentActionName]['role'])) {
                if (! auth()->user()->hasRole($actions[$currentActionName]['role'])) {
                    throw new AuthorizationException();
                }
            }

        });
    }

}
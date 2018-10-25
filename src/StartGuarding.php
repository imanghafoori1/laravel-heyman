<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteMatchListener;

class StartGuarding
{
    public function start()
    {
        foreach (resolve('AllChains')->data as $manager => $f) {
            if ($manager == 'route') {
                continue;
            }
            foreach ($f as $value => $callbacks) {
                foreach ($callbacks as $key => $cb) {
                    resolve($manager)->register($value, $cb, $key);
                }
            }
        }

        $this->guardRoutes();
    }

    private function guardRoutes()
    {
        Route::matched(function (RouteMatched $eventObj) {
            $matchedRoute = [
                $eventObj->route->getName(),
                $eventObj->route->getActionName(),
                $eventObj->request->method().$eventObj->route->uri,
            ];

            $t = resolve('AllChains')->data['route'] ?? [];
            resolve(RouteMatchListener::class)->execMatchedCallbacks($matchedRoute, $t);
        });
    }
}
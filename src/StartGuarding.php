<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Events\RouteMatched;
use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouteMatchListener;

class StartGuarding
{
    public function start()
    {
        $data = resolve('heyman.chains')->data;
        unset($data['route']);

        foreach ($data as $manager => $f) {
            foreach ($f as $value => $callbacks) {
                foreach ($callbacks as $key => $cb) {
                    resolve($manager)->register($value, $cb, $key);
                }
            }
        }

        $this->guardRoutes();

        // We free up the memory here ...
        // Although it is a very small amount
        resolve('heyman.chains')->data = [];
    }

    private function guardRoutes()
    {
        Route::matched(function (RouteMatched $eventObj) {
            $matchedRoute = [
                $eventObj->route->getName(),
                $eventObj->route->getActionName(),
                $eventObj->request->method().$eventObj->route->uri,
            ];

            $t = resolve('heyman.chains')->data['route'] ?? [];
            resolve(RouteMatchListener::class)->execMatchedCallbacks($matchedRoute, $t);
        });
    }
}

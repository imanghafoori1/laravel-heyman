<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

use Closure;
use Illuminate\Support\Str;

class MatchedRoute
{
    static $chainData;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();
        $matchedRoute = $this->getMatchedRouteInto($route);
        $matchedCallbacks = [];
        foreach ($matchedRoute as $info) {
            foreach (static::$chainData as $routeInfo => $callBacks) {
                if (Str::is($routeInfo, $info)) {
                    $matchedCallbacks[] = array_pop($callBacks);
                }
            }
        }

        $this->exec($matchedCallbacks);

        return $next($request);
    }

    /**
     * @param array $closures
     */
    private function exec(array $closures)
    {
        foreach (array_flatten($closures) as $closure) {
            $closure();
        }
    }

    /**
     * @param $route
     *
     * @return array
     */
    private function getMatchedRouteInto($route): array
    {
        $matchedRoute = [
            $route->getName(),
            $route->getActionName(),
            app('request')->method().$route->uri,
        ];

        return array_filter($matchedRoute);
    }
}

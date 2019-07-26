<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Routes;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class MatchedRoute
{
    public static $chainData;

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
        $this->writeDebugInfo();

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
        foreach (Arr::flatten($closures) as $closure) {
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

    public function terminate($request, $response)
    {
        if (! ($debug = app()['heyman_reaction_is_happened_in_debug'] ?? false)) {
            return;
        }

        $this->writeForDebugbar($debug);

        if (is_a($response, RedirectResponse::class)) {
            $s = session();
            $s->flash('heyman.debug.info', $debug);
            $s->reflash();
            $s->save();
        }
    }

    private function writeDebugInfo()
    {
        if ($debug = session()->get('heyman.debug.info')) {
            $this->writeForDebugbar($debug);
        }
    }

    /**
     * @param bool $debug
     */
    private function writeForDebugbar($debug)
    {
        resolve('heyman.debugger')->addMessage('HeyMan Rule Matched in file: ');
        resolve('heyman.debugger')->addMessage($debug[0].' on line: '.$debug[1]);
        resolve('heyman.debugger')->addMessage($debug[2]);
    }
}

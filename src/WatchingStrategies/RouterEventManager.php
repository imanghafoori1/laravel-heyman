<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Str;

class RouterEventManager
{
    private $target;

    private $value;

    private $routeNames = [];

    private $actions = [];

    private $urls = [];

    /**
     * RouterEventManager constructor.
     *
     * @param $target
     * @param $value
     * @return \Imanghafoori\HeyMan\WatchingStrategies\RouterEventManager
     */
    public function init($target, $value)
    {
        $this->target = $target;
        $this->value = $value;

        return $this;
    }

    public function getUrls($url)
    {
        return $this->resolveCallback($url, 'urls');
    }

    public function getRouteNames($routeName)
    {
        return $this->resolveCallback($routeName, 'routeNames');
    }

    public function getActions($action)
    {
        return $this->resolveCallback($action, 'actions');
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        foreach ($this->value as $value) {
            $this->{$this->target}[$value] = $callback;
        }
    }

    /**
     * @param $action
     * @param $type
     *
     * @return \Closure
     */
    private function resolveCallback($action, $type): \Closure
    {
        if (array_key_exists($action, $this->{$type})) {
            $callback = $this->{$type}[$action];

            return $this->wrapCallbackForIgnore($callback);
        }

        foreach ($this->{$type} as $pattern => $callback) {
            if (Str::is($pattern, $action)) {
                return $this->wrapCallbackForIgnore($callback);
            }
        }

        return function () {
        };
    }

    /**
     * @param $callback
     * @return \Closure
     */
    private function wrapCallbackForIgnore($callback): \Closure
    {
        return function () use ($callback) {
            if (! config('heyman_ignore_route', false)) {
                $callback();
            }
        };
    }
}

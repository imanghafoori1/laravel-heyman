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
     *
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
        return $this->resolveCallbacks($url, 'urls');
    }

    public function getRouteNames($routeName)
    {
        return $this->resolveCallbacks($routeName, 'routeNames');
    }

    public function getActions($action)
    {
        return $this->resolveCallbacks($action, 'actions');
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        foreach ($this->value as $value) {
            $this->{$this->target}[$value][] = $callback;
        }
    }

    /**
     * @param $action
     * @param $type
     *
     * @return array
     */
    private function resolveCallbacks($action, $type): array
    {
        if (array_key_exists($action, $this->{$type})) {
            $callbacks = $this->{$type}[$action];

            return $this->wrapCallbacksForIgnore($callbacks);
        }

        foreach ($this->{$type} as $pattern => $callbacks) {
            if (Str::is($pattern, $action)) {
                return $this->wrapCallbacksForIgnore($callbacks);
            }
        }

        return [function () {
        }];
    }

    /**
     * @param $callbacks
     *
     * @return array
     */
    private function wrapCallbacksForIgnore($callbacks): array
    {
        return array_map(function ($callback) {
            return function () use ($callback)
            {
                if (! config('heyman_ignore_route', false)) {
                    $callback();
                }
            };
        }, $callbacks);
    }
}

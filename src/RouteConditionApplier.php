<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Str;

class RouteConditionApplier
{
    private $target;

    private $value;

    private $routeNames = [];

    private $actions = [];

    private $urls = [];

    /**
     * RouteConditionApplier constructor.
     *
     * @param $target
     * @param $value
     */
    public function init($target, $value)
    {
        $this->target = $target;
        $this->value = $value;
        return $this;
    }

    public function getUrls($url)
    {
        if (array_key_exists($url, $this->urls)) {
            return $this->urls[$url];
        };
        
        foreach ($this->urls as $pattern => $callback) {
            if (Str::is($pattern, $url)) {
                return $callback;
            };
        }
        return function(){};
    }

    public function getRouteNames($routeName)
    {
        return $this->routeNames[$routeName] ?? function(){};
    }

    public function getActions($action)
    {
        return $this->actions[$action] ?? function(){};
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
}
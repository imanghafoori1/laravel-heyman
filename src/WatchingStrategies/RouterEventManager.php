<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Illuminate\Support\Str;

class RouterEventManager
{
    private $target;

    private $value;

    private $all = [];

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

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        foreach ($this->value as $value) {
            $this->all[$value][] = [$this->target, $callback];
        }
    }

    /**
     * @param $action
     *
     * @return array
     */
    public function resolveCallbacks($action): array
    {
        if (array_key_exists($action, $this->all)) {
            $callbacks = $this->all[$action];

            return $this->wrapCallbacksForIgnore($callbacks);
        }

        foreach ($this->all as $pattern => $callbacks) {
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
            $c = $callback[1];

            return function () use ($c) {
                if (!config('heyman_ignore_route', false)) {
                    $c();
                }
            };
        }, $callbacks);
    }
}

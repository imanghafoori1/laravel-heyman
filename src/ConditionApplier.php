<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;

class ConditionApplier
{
    private $target;

    private $value;

    private $routeNames = [];

    private $actions = [];

    private $urls = [];

    /**
     * ConditionApplier constructor.
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

    public function youShouldHaveRole($role)
    {
        $this->youShouldPassGate('heyman.youShouldHaveRole', $role);

        return $this;
    }

    public function youShouldPassGate($gate, ...$args)
    {
        $predicate = function () use ($gate, $args) {
            if (Gate::denies($gate, $args)) {
                $this->denyAccess();
            };
        };

        $this->startGuarding($predicate);

        return $this;
    }

    /**
     * @param $callback
     */
    private function setTarget(callable $callback)
    {
        foreach ($this->value as $value) {
            $this->{$this->target}[$value] = $callback;
        }
    }

    private function mapEvents()
    {
        $mapper = function ($view) {
            return $view;
        };

        if ($this->shouldAuthorizeEloquent()) {
            $mapper = function ($model) {
                return "eloquent.{$this->target}: {$model}";
            };
        }

        if ($this->target == 'views') {
            $mapper = function ($view) {
                return 'creating: '.$view;
            };
        }

        $this->value = array_map($mapper, $this->value);
    }


    private function denyAccess()
    {
        throw new AuthorizationException();
    }

    public function beCareful()
    {

    }

    public function getUrls($url)
    {
        return $this->urls[$url] ?? function(){};
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
     * @return bool
     */
    private function shouldAuthorizeRoute(): bool
    {
        return in_array($this->target, ['urls', 'routeNames', 'actions']);
    }

    /**
     * @param $callback
     */
    private function startGuarding(callable $callback)
    {
        if ($this->shouldAuthorizeRoute()) {
            $this->setTarget($callback);
        } else {
            $this->mapEvents();
            Event::listen($this->value, $callback);
            $this->value = [];
        }
    }

    /**
     * @return bool
     */
    private function shouldAuthorizeEloquent(): bool
    {
        return in_array($this->target, ['creating', 'updating', 'saving', 'deleting']);
    }
}
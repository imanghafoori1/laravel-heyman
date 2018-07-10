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
        $predicate = function () use ($role) {
            return ! auth()->user()->hasRole($role);
        };

        $this->setTarget($predicate);

        $this->mapEvents($predicate);

        return $this;
    }

    public function youShouldPassGate($gate, ...$args)
    {
        $predicate = function () use ($gate, $args) {
            return Gate::denies($gate, $args);
        };

        $this->setTarget($predicate);

        $this->mapEvents($predicate);

        return $this;
    }

    /**
     * @param $gate
     */
    private function setTarget($gate)
    {
        foreach ($this->value as $value) {
            $this->{$this->target}[$value] = $gate;
        }
    }

    private function mapEvents($predicate)
    {
        $mapper = function ($view) {
            return $view;
        };

        if (in_array($this->target, ['creating', 'updating', 'saving', 'deleting'])) {
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

        $this->ListenToEvents($predicate);
    }

    /**
     * @param $predicate
     */
    private function ListenToEvents($predicate)
    {
        $cb = function () use ($predicate) {
            if ($predicate()) {
                $this->denyAccess();
            };
        };

        Event::listen($this->value, $cb);

        $this->value = [];
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
        return $this->urls[$url] ?? null;
    }

    public function getRouteNames($routeName)
    {
        return $this->routeNames[$routeName] ?? null;
    }

    public function getActions($action)
    {
        return $this->actions[$action] ?? null;
    }
}
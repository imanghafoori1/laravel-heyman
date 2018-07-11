<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;

class ConditionApplier
{
    private $target;

    private $value;

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

    /**
     * @param $callback
     */
    private function startGuarding(callable $callback)
    {
        $this->mapEvents();
        Event::listen($this->value, $callback);
        $this->value = [];
    }

    /**
     * @return bool
     */
    private function shouldAuthorizeEloquent(): bool
    {
        return in_array($this->target, ['creating', 'updating', 'saving', 'deleting']);
    }
}
<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Event;

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

    private function mapEvents()
    {
        $mapper = function ($view) {
            return $view;
        };

        if ($this->target == 'views') {
            $mapper = function ($view) {
                return 'creating: '.$view;
            };
        }

        $this->value = array_map($mapper, $this->value);
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
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
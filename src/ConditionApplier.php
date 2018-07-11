<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Event;

class ConditionApplier
{
    private $value;

    /**
     * ConditionApplier constructor.
     *
     * @param $value
     */
    public function init($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        Event::listen($this->value, $callback);
        $this->value = [];
    }
}
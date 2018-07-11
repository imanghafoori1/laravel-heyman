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

    /**
     * @param $callback
     */
    public function startGuarding(callable $callback)
    {
        Event::listen($this->value, $callback);
        $this->value = [];
    }
}
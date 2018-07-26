<?php

namespace Imanghafoori\HeyMan\Hooks;

trait EventHooks
{
    /**
     * @param mixed ...$event
     *
     * @return \Imanghafoori\HeyMan\YouShouldHave
     */
    public function whenEventHappens(...$event)
    {
        return $this->holdWhen($this->normalizeInput($event));
    }
}

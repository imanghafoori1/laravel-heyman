<?php

namespace Imanghafoori\HeyMan\Hooks;

trait EventHooks
{
    public function whenEventHappens(...$event)
    {
        return $this->authorize($this->normalizeInput($event));
    }
}
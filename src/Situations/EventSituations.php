<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\WatchingStrategies\EventManager;

class EventSituations extends BaseSituation
{
    /**
     * @param mixed ...$event
     */
    public function whenEventHappens(...$event)
    {
        $this->chain->eventManager = app(EventManager::class)->init($event);
    }
}

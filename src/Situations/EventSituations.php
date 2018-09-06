<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\WatchingStrategies\EventManager;

final class EventSituations extends BaseSituation
{
    /**
     * @param mixed ...$event
     */
    public function whenEventHappens(...$event)
    {
        $this->setManager(EventManager::class, $event);
    }
}

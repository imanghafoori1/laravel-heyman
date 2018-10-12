<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

use Imanghafoori\HeyMan\Situations\BaseSituation;

final class EventSituations extends BaseSituation
{
    /**
     * @param mixed ...$event
     */
    public function whenEventHappens(...$event)
    {
        $this->setManager(EventManager::class, $event);
    }

    public function whenYouReachCheckPoint($name)
    {
        $this->whenEventHappens('heyman_checkpoint_'.$name);
    }
}

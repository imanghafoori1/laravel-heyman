<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

final class EventSituations
{
    /**
     * @param mixed ...$event
     */
    public function whenEventHappens(...$event)
    {
        resolve('heyman.chains')->init(EventManager::class, $event);
    }

    public function whenYouReachCheckPoint($name)
    {
        $this->whenEventHappens('heyman_checkpoint_'.$name);
    }
}

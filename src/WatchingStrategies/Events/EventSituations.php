<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

final class EventSituations
{
    public function hasMethod()
    {
    }

    /**
     * @param mixed ...$event
     */
    public function whenEventHappens(...$event)
    {
        resolve('heyman.chains')->init(EventListeners::class, $event);
    }

    public function whenYouReachCheckPoint($name)
    {
        $this->whenEventHappens('heyman_checkpoint_'.$name);
    }
}

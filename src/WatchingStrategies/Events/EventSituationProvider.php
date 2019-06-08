<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

class EventSituationProvider
{
    public function getListener()
    {
        return EventListeners::class;
    }

    public function getSituationProvider()
    {
        return EventSituations::class;
    }

    public function getForgetKey()
    {
        return 'eventChecks';
    }

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return [
            'whenEventHappens',
            'whenYouReachCheckPoint',
        ];
    }
}

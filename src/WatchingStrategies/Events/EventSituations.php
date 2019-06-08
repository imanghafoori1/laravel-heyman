<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

final class EventSituations
{
    public function hasMethod($method)
    {
        return in_array($method, [
            'whenEventHappens',
            'whenYouReachCheckPoint'
        ]);
    }

    /**
     * @param $method
     * @param $name
     *
     * @return mixed
     */
    public function normalize($method, $name)
    {
        if ($method == 'whenYouReachCheckPoint') {
            $name[0] = 'heyman_checkpoint_'.$name[0];
        }

        return [$name];
    }
}

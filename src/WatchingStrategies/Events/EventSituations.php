<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

final class EventSituations
{
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

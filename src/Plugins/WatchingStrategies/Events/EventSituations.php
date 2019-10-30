<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Events;

final class EventSituations
{
    public function normalize($method, $name)
    {
        if ($method == 'whenYouReachCheckPoint') {
            $name[0] = 'heyman_checkpoint_'.$name[0];
        }

        return [$name];
    }
}

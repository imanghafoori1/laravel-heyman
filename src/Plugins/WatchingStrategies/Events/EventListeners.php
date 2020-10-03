<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Events;

use Imanghafoori\HeyMan\Plugins\WatchingStrategies\Concerns\HeymanSentinel;

class EventListeners implements HeymanSentinel
{
    public function startWatching($data)
    {
        foreach ($data as $event => $callbacks) {
            foreach ($callbacks as $key => $cbs) {
                \Event::listen($event, $cbs[0]);
            }
        }
    }
}

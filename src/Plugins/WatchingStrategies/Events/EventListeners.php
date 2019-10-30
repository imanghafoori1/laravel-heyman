<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Events;

class EventListeners
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

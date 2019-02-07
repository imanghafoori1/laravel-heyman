<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Events;

class EventManager
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

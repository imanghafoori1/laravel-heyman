<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Events;

use Imanghafoori\HeyMan\Contracts\HeymanSentinel;

class EventListeners implements HeymanSentinel
{
    public function startWatching($data)
    {
        foreach ($data as $event => $callbacks) {
            foreach ($callbacks as $key => $cbs) {
                foreach ($cbs as $cb) {
                    \Event::listen($event, $cb);
                }
            }
        }
    }
}

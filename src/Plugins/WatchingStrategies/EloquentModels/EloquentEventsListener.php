<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\EloquentModels;

use Imanghafoori\HeyMan\Plugins\WatchingStrategies\Concerns\ListenToSituation;

class EloquentEventsListener implements ListenToSituation
{
    public function startWatching($data)
    {
        foreach ($data as $model => $f) {
            foreach ($f as $event => $callbacks) {
                foreach ($callbacks as $cb) {
                    $model::{$event}($cb);
                }
            }
        }
    }
}

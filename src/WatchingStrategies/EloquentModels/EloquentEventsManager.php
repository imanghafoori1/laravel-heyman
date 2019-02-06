<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

class EloquentEventsManager
{
    /**
     * @param $callbacks
     * @param $event
     * @param $model
     */
    public function startWatching(string $model, array $callbacks, string $event)
    {
        foreach ($callbacks as $cb) {
            $model::{$event}($cb);
        }
    }
}

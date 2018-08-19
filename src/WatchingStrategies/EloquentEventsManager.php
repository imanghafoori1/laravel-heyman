<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class EloquentEventsManager extends BaseManager
{
    /**
     * @param $callbacks
     * @param $event
     * @param $model
     */
    protected function register(string $model, array $callbacks, string $event)
    {
        foreach ($callbacks as $cb) {
            $model::{$event}($cb);
        }
    }
}

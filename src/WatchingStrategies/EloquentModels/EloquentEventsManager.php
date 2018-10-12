<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

use Imanghafoori\HeyMan\WatchingStrategies\BaseManager;

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

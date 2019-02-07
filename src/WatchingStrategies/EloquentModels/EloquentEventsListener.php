<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\EloquentModels;

class EloquentEventsListener
{
    /**
     * @param array $data
     */
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

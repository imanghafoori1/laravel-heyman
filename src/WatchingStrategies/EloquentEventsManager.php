<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class EloquentEventsManager extends BaseManager
{
    protected $type = 'eloquent';

    /**
     * @param $cb
     * @param $event
     * @param $model
     */
    protected function register($model, $cb, $event)
    {
        foreach ($cb as $c) {
            $model::{$event}($c);
        }
    }
}

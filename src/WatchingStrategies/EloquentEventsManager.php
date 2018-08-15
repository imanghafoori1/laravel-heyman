<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class EloquentEventsManager extends BaseManager
{
    protected $event;

    protected $initial;

    protected $type = 'eloquent';

    /**
     * EloquentEventsManager constructor.
     *
     * @param $event
     * @param $modelClass
     *
     * @return EloquentEventsManager
     */
    public function init($event, $modelClass = [])
    {
        $this->event = $event;
        $this->initial = $modelClass;

        return $this;
    }

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

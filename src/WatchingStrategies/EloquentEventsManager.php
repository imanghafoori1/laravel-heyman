<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\HeyManSwitcher;

class EloquentEventsManager
{
    private $event;

    private $modelClass;

    private $data = [];

    /**
     * EloquentEventsManager constructor.
     *
     * @param $event
     * @param $modelClass
     *
     * @return EloquentEventsManager
     */
    public function init(string $event, array $modelClass) : self
    {
        $this->event = $event;
        $this->modelClass = $modelClass;

        return $this;
    }

    /**
     * @param $callback
     */
    public function commitChain(callable $callback)
    {
        $callback = app(HeyManSwitcher::class)->wrapForIgnorance($callback, 'eloquent');
        foreach ($this->modelClass as $model) {
            $this->data[$model][$this->event][] = $callback;
        }
    }

    public function start()
    {
        foreach ($this->data as $model => $data) {
            foreach ($data as $event => $cb) {
                foreach ($cb as $c) {
                    $model::{$event}($c);
                }
            }
        }
    }

    public function forgetAbout($models, $event = null)
    {
        foreach ($models as $model) {
            if (is_null($event)) {
                unset($this->data[$model]);
            } else {
                unset($this->data[$model][$event]);
            }
        }
    }
}

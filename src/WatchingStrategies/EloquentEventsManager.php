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
        $this->data[] = [$this->modelClass, $this->event, $callback];
    }

    public function start()
    {
        foreach ($this->data as $data) {
            foreach ($data[0] as $model) {
                $model::{$data[1]}($data[2]);
            }
        }
    }

    public function forgetAbout($models, $event = null)
    {
        foreach ($models as $model) {
            foreach ($this->data as $i => $data) {
                if (($key = array_search($model, $data[0])) === false) {
                    continue;
                }

                if (!is_null($event) && $event !== $data[1]) {
                    continue;
                }

                unset($this->data[$i][0][$key]);
            }
        }
    }
}

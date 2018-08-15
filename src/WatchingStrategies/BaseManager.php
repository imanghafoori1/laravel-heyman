<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\HeyManSwitcher;

class BaseManager
{
    protected $initial = [];

    protected $event;

    protected $data = [];

    public function start()
    {
        foreach ($this->data as $value => $callbacks) {
            foreach ($callbacks as $key => $cb) {
                $this->register($value, $cb, $key);
            }
        }
    }

    public function forgetAbout($models, $event = 'default')
    {
        foreach ($models as $model) {
            if (is_null($event)) {
                unset($this->data[$model]);
            } else {
                unset($this->data[$model][$event]);
            }
        }
    }

    /**
     * ViewEventManager constructor.
     *
     * @param $value
     * @param string $param
     *
     * @return ViewEventManager
     */
    public function init(array $value, string $param = 'default')
    {
        $this->initial = $value;
        $this->event = $param;

        return $this;
    }

    /**
     * @param callable $callback
     */
    public function commitChain(callable $callback)
    {
        $switchableListener = app(HeyManSwitcher::class)->wrapForIgnorance($callback, $this->type);

        foreach ($this->initial as $value) {
            $this->data[$value][$this->event][] = $switchableListener;
        }
    }
}

<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;

abstract class BaseManager
{
    use InputNormalizer;

    protected $watchedEntities = [];

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

    public function forgetAbout($models, $event = null)
    {
        $models = $this->normalizeInput($models);

        foreach ($models as $model) {
            if ($event) {
                unset($this->data[$model][$event]);
            } else {
                unset($this->data[$model]);
            }
        }
    }

    /**
     * ViewEventManager constructor.
     *
     * @param $values
     * @param string $param
     *
     * @return self
     */
    public function init(array $values, string $param = 'default'): self
    {
        $this->watchedEntities = $values;
        $this->event = $param;

        return $this;
    }

    /**
     * @param callable $callback
     */
    public function commitChain(callable $callback)
    {
        $switchableListener = resolve(HeyManSwitcher::class)->wrapForIgnorance($callback, get_class($this));

        foreach ($this->watchedEntities as $value) {
            $this->data[$value][$this->event][] = $switchableListener;
        }
    }
}

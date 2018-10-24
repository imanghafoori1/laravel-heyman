<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\Reactions\ReactionFactory;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;

class BaseManager
{
    use InputNormalizer;

    protected $watchedEntities = [];

    protected $event;

    public $manager;

    public $data = [];

    public function start()
    {
        foreach ($this->data as $value => $callbacks) {
            foreach ($callbacks as $key => $cb) {
                resolve($this->manager)->register($value, $cb, $key);
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
     * @param array $values
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

    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    public function commitChain()
    {
        $callback = resolve(ReactionFactory::class)->make();
        $switchableListener = resolve(HeyManSwitcher::class)->wrapForIgnorance($callback, $this->manager);

        foreach ($this->watchedEntities as $value) {
            $this->data[$value][$this->event][] = $switchableListener;
        }
    }
}

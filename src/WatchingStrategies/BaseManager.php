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
        foreach ($this->data as $manager => $f) {
            if($manager == RouterEventManager::class)
                continue;
            foreach ($f as $value => $callbacks) {
                foreach ($callbacks as $key => $cb) {

                    resolve($manager)->register($value, $cb, $key);
                }
            }
        }
    }

    public function forgetAbout($manager, $models, $event = null)
    {
        $models = $this->normalizeInput($models);

        foreach ($models as $model) {
            if ($event) {
                unset($this->data[$manager][$model][$event]);
            } else {
                unset($this->data[$manager][$model]);
            }
        }
    }

    /**
     * ViewEventManager constructor.
     *
     * @param $manager
     * @param array $values
     * @param string $param
     *
     * @return self
     */
    public function init($manager, array $values, string $param = 'default'): self
    {
        $this->manager = $manager;
        $this->watchedEntities = $values;
        $this->event = $param;

        return $this;
    }

    public function commitChain()
    {
        $callback = resolve(ReactionFactory::class)->make();
        $switchableListener = resolve(HeyManSwitcher::class)->wrapForIgnorance($callback, $this->manager);

        foreach ($this->watchedEntities as $value) {
            $this->data[$this->manager][$value][$this->event][] = $switchableListener;
        }
    }
}

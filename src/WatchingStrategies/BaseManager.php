<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\Reactions\ReactionFactory;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;

class BaseManager
{
    use InputNormalizer;

    public $data = [];

    public function start()
    {
        foreach ($this->data as $manager => $f) {
            if ($manager == RouterEventManager::class) {
                continue;
            }
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

    public function commitChain()
    {
        $chain = resolve('heyman.chain');
        $callback = resolve(ReactionFactory::class)->make();
        $manager = $chain->get('manager');
        $switchableListener = resolve(HeyManSwitcher::class)->wrapForIgnorance($callback, $manager);
        $event = $chain->get('event');

        foreach ($chain->get('watchedEntities') as $value) {
            $this->data[$manager][$value][$event][] = $switchableListener;
        }
    }
}

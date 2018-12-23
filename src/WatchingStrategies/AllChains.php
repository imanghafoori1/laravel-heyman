<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

use Imanghafoori\HeyMan\Switching\HeyManSwitcher;
use Imanghafoori\HeyMan\Reactions\ReactionFactory;
use Imanghafoori\HeyMan\Normilizers\InputNormalizer;

class AllChains
{
    use InputNormalizer;

    public $data = [];

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

<?php

namespace Imanghafoori\HeyMan\Core;

use Imanghafoori\HeyMan\Switching\HeyManSwitcher;

class ChainCollection
{
    public $data = [];

    public function forgetAbout($manager, $models, $event = null)
    {
        $models = is_array($models[0]) ? $models[0] : $models;

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

    /**
     * initialize the chain.
     *
     * @param  $manager
     * @param  array  $values
     * @param  string  $param
     */
    public function init($manager, array $values, string $param = 'default')
    {
        $chain = resolve('heyman.chain');
        $chain->set('manager', $manager);
        $chain->set('watchedEntities', $values);
        $chain->set('event', $param);
    }
}

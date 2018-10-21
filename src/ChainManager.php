<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\ReactionFactory;

class ChainManager
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chain;

    public function startChain()
    {
        $this->chain = new Chain();
        $this->chain->chainInfo = [
            'beforeReaction' => [],
            'debugInfo'      => ['file' => '', 'line' => '', 'args' => ''],
            'responseType'   => 'nothing',
            'data'           => [],
        ];
    }

    public function submitChainConfig()
    {
        $callbackListener = resolve(ReactionFactory::class)->make();
        $this->get('eventManager')->commitChain($callbackListener);
    }

    public function commitCalledMethod($args, $methodName)
    {
        $this->push('data', $args);
        $this->set('responseType', $methodName);
    }

    public function get($key)
    {
        return $this->chain->chainInfo[$key] ?? null;
    }

    public function set($key, $value)
    {
        $this->chain->chainInfo[$key] = $value;
    }

    public function push($key, $value)
    {
        $this->chain->chainInfo[$key][] = $value;
    }
}

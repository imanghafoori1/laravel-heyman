<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Reactions\ReactionFactory;

class ChainManager
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chainInfo = [];

    public function startChain()
    {
        $this->chainInfo = [
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

    public function get($key)
    {
        return $this->chainInfo[$key] ?? null;
    }

    public function set($key, $value)
    {
        $this->chainInfo[$key] = $value;
    }

    public function push($key, $value)
    {
        $this->chainInfo[$key][] = $value;
    }
}

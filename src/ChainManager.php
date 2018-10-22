<?php

namespace Imanghafoori\HeyMan;

class ChainManager
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chainInfo = [];

    public function startChain()
    {
        $this->chainInfo = [];
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

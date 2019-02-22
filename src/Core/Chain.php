<?php

namespace Imanghafoori\HeyMan\Core;

class Chain
{
    /**
     * @var array
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

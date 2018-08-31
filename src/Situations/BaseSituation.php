<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Chain;

abstract class BaseSituation
{
    protected $chain;

    public function hasMethod($method)
    {
        return false;
    }

    /**
     * HeyMan constructor.
     *
     * @param Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }
}

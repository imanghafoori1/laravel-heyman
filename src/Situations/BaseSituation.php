<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\Chain;

abstract class BaseSituation
{
    use InputNormalizer;

    protected $chain;

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
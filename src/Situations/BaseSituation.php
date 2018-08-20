<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Chain;
use Imanghafoori\HeyMan\Normilizers\InputNormalizer;

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

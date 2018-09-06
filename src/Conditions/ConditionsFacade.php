<?php

namespace Imanghafoori\HeyMan\Conditions;

use Imanghafoori\HeyMan\Chain;

class ConditionsFacade
{
    /**
     * @var Chain
     */
    private $chain;

    /**
     * YouShouldHave constructor.
     *
     * @param Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    use \Imanghafoori\HeyMan\Conditions\Authentication;
    use \Imanghafoori\HeyMan\Conditions\Gate;
    use \Imanghafoori\HeyMan\Conditions\Callbacks;
    use \Imanghafoori\HeyMan\Conditions\Session;

}
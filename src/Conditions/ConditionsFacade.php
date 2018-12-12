<?php

namespace Imanghafoori\HeyMan\Conditions;

use Imanghafoori\HeyMan\Conditions\Traits\Authentication;

class ConditionsFacade
{
    private $methods = [

    ];

    /**
     * ConditionsFacade constructor.
     *
     * @param array $methods
     */
    public function __construct()
    {
        $this->methods = $this->methods + Authentication::conditions();
    }

    public function call($method, $param)
    {

    }

    use Traits\Gate;
    use Traits\Callbacks;
    use Traits\Session;
}

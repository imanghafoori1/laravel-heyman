<?php

namespace Imanghafoori\HeyMan\Conditions;

use Imanghafoori\HeyMan\Conditions\Traits\Authentication;
use Imanghafoori\HeyMan\Conditions\Traits\Callbacks;
use Imanghafoori\HeyMan\Conditions\Traits\Gate;
use Imanghafoori\HeyMan\Conditions\Traits\Session;

class ConditionsFacade
{
    private $methods = [];

    /**
     * ConditionsFacade constructor.
     *
     * @param array $methods
     */
    public function __construct()
    {
        $this->methods = Authentication::conditions() + Callbacks::conditions() + Gate::conditions() + Session::conditions('');
    }

    public function call($method, $param)
    {
        return $this->methods[$method](...$param);
    }
}

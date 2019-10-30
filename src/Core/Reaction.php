<?php

namespace Imanghafoori\HeyMan\Core;

class Reaction extends ConditionsFacade
{
    public function __call($method, $param)
    {
        return $this->_call($method, $param);
    }
}

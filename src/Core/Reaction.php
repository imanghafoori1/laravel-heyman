<?php

namespace Imanghafoori\HeyMan\Core;

class Reaction extends ProxyClass
{
    public function __call($method, $param)
    {
        return $this->_call($method, $param);
    }
}

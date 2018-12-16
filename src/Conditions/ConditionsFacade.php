<?php

namespace Imanghafoori\HeyMan\Conditions;

class ConditionsFacade
{
    private $methods = [];

    public function _call($method, $param)
    {
        if(in_array($method, ['thisClosureShouldAllow', 'thisMethodShouldAllow'])) {
            $param = [
                'callback' => $param[0],
                'parameters' => $param[1] ?? [],
            ];
        }

        if (isset($this->methods[$method])) {
            return app()->call($this->methods[$method], $param);
        }

        throw new \BadMethodCallException($method.' does not exists as a Heyman condition');
    }

    public function define($methodName, $callable)
    {
        $this->methods[$methodName] = $callable;
    }
}

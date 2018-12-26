<?php

namespace Imanghafoori\HeyMan\Conditions;

class ConditionsFacade
{
    private $methods = [];

    public function _call($method, $param)
    {
        if (! isset($this->methods[$method])) {
            throw new \BadMethodCallException($method.' does not exists as a Heyman condition');
        }
        $condition = $this->methods[$method];

        if (is_callable($condition)) {
            return $condition(...$param);
        }

        list($class, $method) = explode('@', $condition);

        return call_user_func_array([new $class, $method], $param);
    }

    public function define($methodName, $callable)
    {
        if (is_callable($callable) || (is_string($callable) and mb_strpos($callable, '@'))) {
            $this->methods[$methodName] = $callable;
        } else {
            throw new \InvalidArgumentException("$callable should be string Class@method or a php callable");
        }
    }
}

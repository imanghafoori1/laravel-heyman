<?php

namespace Imanghafoori\HeyMan\Core;

class ProxyClass
{
    private $methods = [];

    private $aliases = [];

    public function _call($method, $param)
    {
        $method = $this->aliases[$method] ?? $method;

        if (! isset($this->methods[$method])) {
            throw new \BadMethodCallException($method.' does not exist');
        }

        $condition = $this->methods[$method];

        if (is_callable($condition)) {
            return call_user_func_array($condition, $param);
        }

        [$class, $method] = explode('@', $condition);

        return call_user_func_array([new $class, $method], $param);
    }

    public function define($methodName, $callable)
    {
        if (is_callable($callable) || (is_string($callable) && mb_strpos($callable, '@'))) {
            $this->methods[$methodName] = $callable;
        } else {
            throw new \InvalidArgumentException("$callable should be string Class@method or a php callable");
        }
    }

    public function alias(string $currentName, string $newName, $override = true)
    {
        if ($override || ! isset($this->aliases[$newName])) {
            $this->aliases[$newName] = $currentName;

            return true;
        }

        return false;
    }
}

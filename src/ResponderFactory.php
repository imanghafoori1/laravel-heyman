<?php

namespace Imanghafoori\HeyMan;

class ResponderFactory
{
    private $chain;

    /**
     * ResponderFactory constructor.
     *
     * @param \Imanghafoori\HeyMan\Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    public function make()
    {
        $props = ['abort', 'exception', 'response', 'redirect', 'respondFrom',];

        foreach ($props as $p) {
            $value = $this->chain->$p;
            if ($value) {
                return $this->$p($value);
            }
        }

        return function () {
        };
    }

    public function abort($abort)
    {
        return function () use ($abort) {
            abort(...$abort);
        };
    }

    /**
     * @param $e
     * @param $cb
     *
     * @return \Closure
     */
    public function exception($e): \Closure
    {
        return function () use ($e) {
            $exClass = $e['class'];

            throw new $exClass($e['message']);
        };
    }

    /**
     * @param $resp
     *
     * @return \Closure
     */
    public function response($resp): \Closure
    {
        $responder = function () use ($resp) {
            $respObj = response();
            foreach ($resp as $call) {
                list($method, $args) = $call;
                $respObj = $respObj->{$method}(...$args);
            }
            respondWith($respObj);
        };

        return $responder;
    }

    public function redirect($resp): \Closure
    {
        return function () use ($resp) {
            $respObj = redirect();
            foreach ($resp as $call) {
                list($method, $args) = $call;
                $respObj = $respObj->{$method}(...$args);
            }
            respondWith($respObj);
        };
    }

    public function respondFrom($method)
    {
        return function () use ($method) {
            respondWith(app()->call(...$method));
        };
    }

    public function validatorCallback($rules): \Closure
    {
        $validator = function () use ($rules) {
            if (is_callable($rules)) {
                $rules = $rules();
            }
            $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), $rules);
            $validator->validate();
        };

        return app(HeyManSwitcher::class)->wrapForIgnorance($validator, 'validation');
    }
}

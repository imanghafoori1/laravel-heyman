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
        $m = $this->chain->methodName;
        $parameters = $this->chain->data;
        return $this->$m($parameters);
    }

    public function abort($abort)
    {
        return function () use ($abort) {
            abort(...$abort[0]);
        };
    }

    public function nothing()
    {
        return function() {
        };
    }

    /**
     * @param $e
     *
     * @return \Closure
     */
    public function exception($e): \Closure
    {
        return function () use ($e) {
            $exClass = $e[0]['class'];

            throw new $exClass($e[0]['message']);
        };
    }

    /**
     * @param $resp
     *
     * @return \Closure
     */
    public function response($resp): \Closure
    {
        return function () use ($resp) {
            $respObj = response();
            foreach ($resp as $call) {
                list($method, $args) = $call;
                $respObj = $respObj->{$method}(...$args);
            }
            respondWith($respObj);
        };
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
            respondWith(app()->call(...$method[0]));
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

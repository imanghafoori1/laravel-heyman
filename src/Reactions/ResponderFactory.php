<?php

namespace Imanghafoori\HeyMan\Reactions;

use Illuminate\Contracts\Validation\Factory;
use Imanghafoori\HeyMan\Chain;
use Imanghafoori\HeyMan\HeyManSwitcher;

class ResponderFactory
{
    private $chain;

    /**
     * ResponderFactory constructor.
     *
     * @param Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    public function make()
    {
        $m = $this->chain->responseType;
        $parameters = $this->chain->data;

        return $this->$m($parameters);
    }

    protected function abort($abort): \Closure
    {
        return function () use ($abort) {
            abort(...$abort);
        };
    }

    protected function nothing(): \Closure
    {
        return function () {
        };
    }

    /**
     * @param $e
     *
     * @return \Closure
     */
    protected function exception(array $e): \Closure
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
    protected function response(array $resp): \Closure
    {
        return function () use ($resp) {
            $this->sendResponse($resp, response());
        };
    }

    protected function redirect(array $resp): \Closure
    {
        return function () use ($resp) {
            $this->sendResponse($resp, redirect());
        };
    }

    protected function respondFrom($method): \Closure
    {
        return function () use ($method) {
            respondWith(app()->call(...$method));
        };
    }

    /**
     * @param array $resp
     * @param $respObj
     */
    private function sendResponse(array $resp, $respObj)
    {
        foreach ($resp as $call) {
            list($method, $args) = $call;
            $respObj = $respObj->{$method}(...$args);
        }
        respondWith($respObj);
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param string|\Closure $modifier
     * @param array|\Closure  $rules
     * @param array           $messages
     * @param array           $customAttributes
     *
     * @return \Closure
     */
    public function validatorCallback($modifier, $rules, array $messages = [], array $customAttributes = []): \Closure
    {
        $validator = function () use ($modifier, $rules, $messages, $customAttributes) {
            if (is_callable($rules)) {
                $rules = $rules();
            }

            $data = app()->call($modifier, [request()->all()]);
            $validator = app(Factory::class)->make($data, $rules, $messages, $customAttributes);
            $validator->validate();
        };

        return app(HeyManSwitcher::class)->wrapForIgnorance($validator, 'validation');
    }
}

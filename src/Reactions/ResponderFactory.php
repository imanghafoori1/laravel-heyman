<?php

namespace Imanghafoori\HeyMan\Reactions;

use Illuminate\Contracts\Validation\Factory;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;
use Illuminate\Http\Exceptions\HttpResponseException;

final class ResponderFactory
{
    public function make()
    {
        $chain = resolve('heyman.chain');
        $m = $chain->get('responseType') ?? 'nothing';
        $data = $chain->get('data') ?? [];

        return $this->$m(...$data);
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

    protected function exception(array $e): \Closure
    {
        return function () use ($e) {
            $exClass = $e[0];
            $message = $e[1];

            throw new $exClass($message);
        };
    }

    protected function response(...$resp): \Closure
    {
        return function () use ($resp) {
            $this->sendResponse($resp, response());
        };
    }

    protected function redirect(...$resp): \Closure
    {
        return function () use ($resp) {
            $this->sendResponse($resp, redirect());
        };
    }

    protected function respondFrom($method): \Closure
    {
        return function () use ($method) {
            throw new HttpResponseException(app()->call(...$method));
        };
    }

    private function sendResponse(array $methodCalls, $respObj)
    {
        foreach ($methodCalls as $call) {
            [$method, $args] = $call;
            $respObj = $respObj->{$method}(...$args);
        }

        throw new HttpResponseException($respObj);
    }

    public function validatorCallback($modifier, $rules, array $messages = [], array $customAttributes = []): \Closure
    {
        $validator = function () use ($modifier, $rules, $messages, $customAttributes) {
            if (is_callable($rules)) {
                $rules = call_user_func($rules);
            }

            $data = app()->call($modifier, [request()->all()]);
            $validator = resolve(Factory::class)->make($data, $rules, $messages, $customAttributes);
            $validator->validate();
        };

        return resolve(HeyManSwitcher::class)->wrapForIgnorance($validator, 'validation');
    }
}

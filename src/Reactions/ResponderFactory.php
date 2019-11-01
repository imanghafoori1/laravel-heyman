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
        $method = $chain->get('responseType') ?? 'nothing';
        $data = $chain->get('data') ?? [];

        return $this->$method(...$data);
    }

    protected function abort($args)
    {
        return function () use ($args) {
            abort(...$args);
        };
    }

    protected function nothing()
    {
        return function () {
        };
    }

    protected function exception(array $e)
    {
        return function () use ($e) {
            $exClass = $e[0];
            $message = $e[1];

            throw new $exClass($message);
        };
    }

    protected function response(...$resp)
    {
        return function () use ($resp) {
            $this->sendResponse($resp, response());
        };
    }

    protected function redirect(...$resp)
    {
        return function () use ($resp) {
            $this->sendResponse($resp, redirect());
        };
    }

    protected function respondFrom($method)
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

    public function validatorCallback($modifier, $rules)
    {
        $validator = function () use ($modifier, $rules) {
            $this->makeValidator($modifier, $rules)->validate();
        };

        return resolve(HeyManSwitcher::class)->wrapForIgnorance($validator, 'validation');
    }

    public function validationPassesCallback($modifier, $rules)
    {
        $validator = function () use ($modifier, $rules) {
            return ! $this->makeValidator($modifier, $rules)->fails();
        };

        return resolve(HeyManSwitcher::class)->wrapForIgnorance($validator, 'validation');
    }

    public function makeValidator($modifier, $rules)
    {
        if (is_callable($rules[0])) {
            $rules[0] = call_user_func($rules[0]);
        }

        $newData = app()->call($modifier, [request()->all()]);

        return resolve(Factory::class)->make($newData, ...$rules);
    }
}

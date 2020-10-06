<?php

namespace Imanghafoori\HeyMan\Reactions;

use Illuminate\Contracts\Validation\Factory;
use Imanghafoori\HeyMan\Core\Reaction;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;

final class Validator
{
    private $validationData;

    private $modifier;

    public function __construct(array $validationData)
    {
        $this->validationData = $validationData;
    }

    public function otherwise()
    {
        $rules = $this->validationData;
        $result = $this->validationPassesCallback($this->getModifier(), $rules);

        resolve('heyman.chain')->set('condition', $result);

        return resolve(Reaction::class);
    }

    public function beforeValidationModifyData($callable)
    {
        $this->modifier = $callable;
    }

    public function validatorCallback($modifier, $rules)
    {
        $validator = function () use ($modifier, $rules) {
            $this->makeValidator($modifier, $rules)->validate();
        };

        return $this->wrapForIgnore($validator);
    }

    public function validationPassesCallback($modifier, $rules)
    {
        $validator = function () use ($modifier, $rules) {
            $v = $this->makeValidator($modifier, $rules);

            resolve('heyman.chain')->set('condition_meta', $v);

            return ! $v->fails();
        };

        return $this->wrapForIgnore($validator);
    }

    public function makeValidator($modifier, $rules)
    {
        if (is_callable($rules[0])) {
            $rules[0] = call_user_func($rules[0]);
        }

        $newData = app()->call($modifier, [request()->all()]);

        return resolve(Factory::class)->make($newData, ...$rules);
    }

    public function __destruct()
    {
        try {
            $chain = app('heyman.chain');
            $condition = $chain->get('condition');

            if ($condition) {
                return resolve('heyman.chains')->commitChain();
            }

            $data = $this->validationData;
            $condition = $this->validatorCallback($this->getModifier(), $data);
            $chain->set('condition', $condition);

            resolve('heyman.chains')->commitChain();
        } catch (\Throwable $throwable) {
            //
        }
    }

    private function wrapForIgnore($validator)
    {
        return resolve(HeyManSwitcher::class)->wrapForIgnorance($validator, 'validation');
    }

    private function getModifier()
    {
        return $this->modifier ?: function () {
            return request()->all();
        };
    }
}

<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Core\Reaction;
use Illuminate\Contracts\Validation\Factory;
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
        $modifier = $this->modifier ?: function ($args) {
            return $args;
        };
        $validator = function () use ($modifier, $rules) {
            if (is_callable($rules[0])) {
                $rules[0] = call_user_func($rules[0]);
            }

            $newData = app()->call($modifier, [request()->all()]);
            $validator = resolve(Factory::class)->make($newData, ...$rules);

            return ! $validator->fails();
        };

        $result = resolve(HeyManSwitcher::class)->wrapForIgnorance($validator, 'validation');

        resolve('heyman.chain')->set('condition', $result);

        return resolve(Reaction::class);
    }

    public function beforeValidationModifyData($callable)
    {
        $this->modifier = $callable;
    }

    public function __destruct()
    {
        $data = $this->validationData;
        $modifier = $this->modifier ?: function ($args) {
            return $args;
        };
        $chain = resolve('heyman.chain');
        $condition = $chain->get('condition');
        if (! $condition) {
            $condition = resolve(ResponderFactory::class)->validatorCallback($modifier, $data);
            $chain->set('condition', $condition);
        }
        resolve('heyman.chains')->commitChain();
    }
}

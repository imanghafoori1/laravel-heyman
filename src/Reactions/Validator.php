<?php

namespace Imanghafoori\HeyMan\Reactions;

final class Validator
{
    private $validationData;

    private $modifier;

    public function __construct(array $validationData)
    {
        $this->validationData = $validationData;
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
        $condition = resolve(ResponderFactory::class)->validatorCallback($modifier, ...$data);
        $chain->set('condition', $condition);
        resolve('heyman.chains')->commitChain();
    }
}

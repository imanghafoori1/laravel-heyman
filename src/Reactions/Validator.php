<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Core\Reaction;

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

        $result = resolve(ResponderFactory::class)->validationPassesCallback($modifier, $rules);

        resolve('heyman.chain')->set('condition', $result);

        return resolve(Reaction::class);
    }

    public function beforeValidationModifyData($callable)
    {
        $this->modifier = $callable;
    }

    public function __destruct()
    {
        try {
            $chain = app('heyman.chain');
            $condition = $chain->get('condition');

            if (! $condition) {
                $data = $this->validationData;
                $modifier = $this->modifier ?: function ($args) {
                    return $args;
                };

                $condition = resolve(ResponderFactory::class)->validatorCallback($modifier, $data);
                $chain->set('condition', $condition);
            }

            resolve('heyman.chains')->commitChain();
        } catch (\Throwable $throwable) {
            //
        }
    }
}

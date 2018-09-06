<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

final class Validator
{
    /**
     * @var array
     */
    private $validationData;

    private $modifier;

    /**
     * YouShouldHave constructor.
     *
     * @param $validationData
     */
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
        $modifier = $this->modifier ?: function ($d) {
            return $d;
        };
        $chain = resolve(Chain::class);
        $chain->condition = resolve(ResponderFactory::class)->validatorCallback($modifier, ...$data);
        $chain->submitChainConfig();
    }
}

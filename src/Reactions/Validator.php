<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

class Validator
{
    /**
     * @var Chain
     */
    private $chain;
    /**
     * @var array
     */
    private $validationData;

    private $modifier;

    /**
     * YouShouldHave constructor.
     *
     * @param Chain $chain
     * @param $validationData
     */
    public function __construct(Chain $chain, array $validationData)
    {
        $this->chain = $chain;
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
        $this->chain->condition = app(ResponderFactory::class)->validatorCallback($modifier, ...$data);
        app(Chain::class)->submitChainConfig();
    }
}

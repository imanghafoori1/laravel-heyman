<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

class Validator
{
    /**
     * @var Chain
     */
    private $chain;

    private $validationData;

    /**
     * YouShouldHave constructor.
     *
     * @param Chain $chain
     * @param $validationData
     */
    public function __construct(Chain $chain, $validationData)
    {
        $this->chain = $chain;
        $this->validationData = $validationData;
    }

    public function beforeValidationModifyData($callable)
    {
        $this->validationData[0] = app()->call($callable, [$this->validationData[0]]);
    }

    public function __destruct()
    {
        $data = $this->validationData;
        $this->chain->predicate = app(ResponderFactory::class)->validatorCallback(...$data);
        app(Chain::class)->submitChainConfig();
    }
}
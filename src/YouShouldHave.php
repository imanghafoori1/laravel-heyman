<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Conditions\ConditionsFacade;

final class YouShouldHave
{
    use \Imanghafoori\HeyMan\Conditions\RequestValidation;

    public $condition;

    /**
     * @var Chain
     */
    private $chain;

    /**
     * YouShouldHave constructor.
     *
     * @param Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    public function __call($method, $args)
    {
        resolve(Chain::class)->condition = (new ConditionsFacade($this->chain))->$method(...$args);
        return resolve(Otherwise::class);
    }

    public function youShouldAlways()
    {
        return $this->thisValueShouldAllow(false)->otherwise();
    }
}

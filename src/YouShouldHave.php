<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Conditions\ConditionsFacade;

final class YouShouldHave
{
    use \Imanghafoori\HeyMan\Conditions\RequestValidation;

    public $condition;

    public function __call($method, $args)
    {
        resolve(Chain::class)->condition = app(ConditionsFacade::class)->$method(...$args);

        return resolve(Otherwise::class);
    }

    public function youShouldAlways()
    {
        return $this->thisValueShouldAllow(false)->otherwise();
    }
}

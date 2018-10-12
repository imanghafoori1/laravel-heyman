<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Conditions\ConditionsFacade;
use Imanghafoori\HeyMan\Conditions\RequestValidation;
use Imanghafoori\HeyMan\Reactions\Reactions;

final class YouShouldHave
{
    use RequestValidation;

    public $condition;

    public function __call($method, $args): Otherwise
    {
        resolve(Chain::class)->condition = app(ConditionsFacade::class)->$method(...$args);

        return resolve(Otherwise::class);
    }

    public function always() : Reactions
    {
        return $this->thisValueShouldAllow(false)->otherwise();
    }
}

<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Conditions\ConditionsFacade;
use Imanghafoori\HeyMan\Conditions\RequestValidation;
use Imanghafoori\HeyMan\Reactions\Reactions;

/**
 * Class YouShouldHave.
 *
 * @method youShouldBeGuest($guard = null)
 * @method youShouldBeLoggedIn($guard = null)
 *
 * @method thisGateShouldAllow($gate, ...$parameters)
 * @method youShouldHaveRole(string $role)
 *
 * @method thisClosureShouldAllow(callable $callback, array $parameters = [])
 * @method thisValueShouldAllow($value)
 * @method thisMethodShouldAllow($callback, array $parameters = [])
 *
 * @method sessionShouldHave($key)
 *
 */
final class YouShouldHave
{
    use RequestValidation;

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

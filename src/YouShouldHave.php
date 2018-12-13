<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Conditions\ConditionsFacade;
use Imanghafoori\HeyMan\Conditions\RequestValidation;
use Imanghafoori\HeyMan\Reactions\Reactions;

/**
 * Class YouShouldHave.
 *
 * @method Otherwise youShouldBeGuest($guard = null)
 * @method Otherwise youShouldBeLoggedIn($guard = null)
 * @method Otherwise thisGateShouldAllow($gate, ...$parameters)
 * @method Otherwise youShouldHaveRole(string $role)
 * @method Otherwise thisClosureShouldAllow(callable $callback, array $parameters = [])
 * @method Otherwise thisValueShouldAllow($value)
 * @method Otherwise thisMethodShouldAllow($callback, array $parameters = [])
 * @method Otherwise sessionShouldHave($key)
 */
final class YouShouldHave
{
    use RequestValidation;

    public function __call(string $method, $args): Otherwise
    {
        resolve('heyman.chain')->set('condition', app(ConditionsFacade::class)->call($method, $args));

        return resolve(Otherwise::class);
    }

    public function always() : Reactions
    {
        return $this->thisValueShouldAllow(false)->otherwise();
    }
}

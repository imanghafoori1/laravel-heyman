<?php

namespace Imanghafoori\HeyMan\Core;

use Imanghafoori\HeyMan\Conditions\RequestValidation;

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
final class Condition
{
    use RequestValidation;

    public function __call(string $method, $args): Otherwise
    {
        resolve('heyman.chain')->set('condition', resolve(ConditionsFacade::class)->_call($method, $args));

        return resolve(Otherwise::class);
    }

    public function always()
    {
        return $this->thisValueShouldAllow(false)->otherwise();
    }
}

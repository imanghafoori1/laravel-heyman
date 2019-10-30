<?php

namespace Imanghafoori\HeyMan\Core;

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
    public function __call(string $method, $args)
    {
        $result = resolve(ConditionsFacade::class)->_call($method, $args);

        if ($result instanceof \Closure) {
            resolve('heyman.chain')->set('condition', $result);

            return resolve(Otherwise::class);
        }

        return $result;
    }

    public function always()
    {
        return $this->thisValueShouldAllow(false)->otherwise();
    }
}

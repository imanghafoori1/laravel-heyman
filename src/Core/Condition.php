<?php

namespace Imanghafoori\HeyMan\Core;

/**
 * Class Condition.
 *
 * @method Otherwise youShouldBeGuest($guard = null)
 * @method Otherwise youShouldBeLoggedIn($guard = null)
 * @method Otherwise checkAuth($guard = null)
 * @method Otherwise yourRequestShouldBeValid($rules, array $messages = [], array $customAttributes = [])
 * @method Otherwise validate($rules, array $messages = [], array $customAttributes = [])
 * @method Otherwise thisGateShouldAllow($gate, ...$parameters)
 * @method Otherwise checkGate($gate, ...$parameters)
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

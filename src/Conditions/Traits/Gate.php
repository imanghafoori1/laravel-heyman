<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

use Illuminate\Support\Facades\Gate as GateFacade;

class Gate
{
    public static function conditions()
    {
        $thisGateShouldAllow = function ($gate, ...$parameters) {
            $gate = self::defineNewGate($gate);

            return function (...$payload) use ($gate, $parameters) {
                return GateFacade::allows($gate, (array_merge($parameters, ...$payload)));
            };
        };

        $youShouldHaveRole = function (string $role) use ($thisGateShouldAllow) {
            return $thisGateShouldAllow('heyman.youShouldHaveRole', $role);
        };

        return compact('youShouldHaveRole', 'thisGateShouldAllow');
    }

    private static function defineNewGate($gate): string
    {
        // Define a Gate for inline closures passed as gate
        if (is_callable($gate)) {
            $closure = $gate;
            $gate = str_random(10);
            GateFacade::define($gate, $closure);
        }

        // Define a Gate for "class@method" gates
        if (is_string($gate) && str_contains($gate, '@')) {
            GateFacade::define($gate, $gate);
        }

        return $gate;
    }
}

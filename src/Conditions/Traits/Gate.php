<?php

namespace Imanghafoori\HeyMan\Conditions\Traits;

use Illuminate\Support\Facades\Gate as GateFacade;

class Gate
{
    public function thisGateShouldAllow($gate, ...$parameters)
    {
        $gate = $this->defineNewGate($gate);

        return function (...$payload) use ($gate, $parameters) {
            return GateFacade::allows($gate, (array_merge($parameters, ...$payload)));
        };
    }

    /**
     * @param $gate
     *
     * @return string
     */
    private function defineNewGate($gate): string
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

    public function youShouldHaveRole(string $role)
    {
        return $this->thisGateShouldAllow('heyman.youShouldHaveRole', $role);
    }
}

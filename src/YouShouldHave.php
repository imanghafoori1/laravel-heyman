<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Gate;

class YouShouldHave
{
    public $predicate;

    public function youShouldHaveRole($role)
    {
        return $this->thisGateShouldAllow('heyman.youShouldHaveRole', $role);
    }

    public function thisGateShouldAllow($gate, ...$args)
    {
        $gate = $this->defineNewGate($gate);

        $this->predicate = function () use ($gate, $args) {
            return Gate::allows($gate, $args);
        };

        return new Otherwise();
    }

    public function thisClosureShouldAllow($callback, array $parameters = [])
    {
        return $this->thisMethodShouldAllow($callback, $parameters);
    }

    public function thisMethodShouldAllow($callback, array $parameters = [])
    {
        $this->predicate = function () use ($callback, $parameters) {
            return (bool) app()->call($callback, $parameters);
        };

        return new Otherwise();
    }

    public function thisValueShouldAllow($value)
    {
        $this->predicate = function () use ($value) {
            return (bool) $value;
        };

        return new Otherwise();
    }

    public function youShouldBeGuest()
    {
        $this->predicate = function () {
            return auth()->guest();
        };

        return new Otherwise();
    }

    public function youShouldBeLoggedIn()
    {
        $this->predicate = function () {
            return auth()->check();
        };

        return new Otherwise();
    }

    public function immediately()
    {
        $this->predicate = function () {
            return false;
        };

        return new Responder();
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
            Gate::define($gate, $closure);
        }

        // Define a Gate for "class@method" gates
        if (is_string($gate) && str_contains($gate, '@')) {
            Gate::define($gate, $gate);
        }

        return $gate;
    }
}

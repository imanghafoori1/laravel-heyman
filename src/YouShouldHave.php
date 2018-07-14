<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Gate;

class YouShouldHave
{
    public $predicate;

    public function youShouldHaveRole($role)
    {
        return $this->thisGateMustAllow('heyman.youShouldHaveRole', $role);
    }

    public function thisGateMustAllow($gate, ...$args)
    {
        if (is_callable($gate)) {
            Gate::define(str_random(10), $gate);
        }

        if (is_string($gate) && str_contains($gate, '@')) {
            Gate::define($gate, $gate);
        }

        $this->predicate = function () use ($gate, $args) {
            return Gate::allows($gate, $args);
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
}
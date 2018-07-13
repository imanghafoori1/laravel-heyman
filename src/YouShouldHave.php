<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Support\Facades\Gate;

class YouShouldHave
{
    public $predicate;

    public function youShouldHaveRole($role)
    {
        return $this->youShouldPassGate('heyman.youShouldHaveRole', $role);
    }

    public function youShouldPassGate($gate, ...$args)
    {
        if (str_contains($gate, '@')) {
            Gate::define($gate, $gate);
        }

        $this->predicate = function () use ($gate, $args) {
            return Gate::allows($gate, $args);
        };

        return new BeCareful();
    }

    public function youShouldBeGuest()
    {
        $this->predicate = function () {
            return auth()->guest();
        };

        return new BeCareful();
    }
}
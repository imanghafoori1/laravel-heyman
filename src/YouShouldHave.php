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

    public function youShouldBeGuest()
    {
        $this->predicate = function () {
            return ! auth()->guest();
        };

        return new BeCareful();
    }

    public function youShouldPassGate($gate, ...$args)
    {
        $this->predicate = function () use ($gate, $args) {
            return Gate::denies($gate, $args);
        };

        return new BeCareful();
    }
}
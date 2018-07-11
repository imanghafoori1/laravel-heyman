<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class YouShouldHave
{
    public function youShouldHaveRole($role)
    {
        $this->youShouldPassGate('heyman.youShouldHaveRole', $role);

        return $this;
    }

    public function youShouldPassGate($gate, ...$args)
    {
        $predicate = function () use ($gate, $args) {
            if (Gate::denies($gate, $args)) {
                $this->denyAccess();
            };
        };

        app('hey_man_route_authorizer')->startGuarding($predicate);

        return $this;
    }

    private function denyAccess()
    {
        throw new AuthorizationException();
    }

    public function beCareful()
    {

    }
}
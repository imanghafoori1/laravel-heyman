<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class YouShouldHave
{
    private $authorizer;

    /**
     * YouShouldHave constructor.
     *
     * @param $authorizer
     */
    public function __construct($authorizer)
    {
        $this->authorizer = $authorizer;
    }

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

        $this->authorizer->startGuarding($predicate);

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
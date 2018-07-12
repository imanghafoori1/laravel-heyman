<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;

class BeCareful
{
    public function beCareful()
    {
        $predicate = app('hey_man_you_should_have')->predicate;

        $callbackListener = function () use ($predicate) {
            if (! $predicate()) {
                $this->denyAccess();
            }
        };
        app('hey_man')->authorizer->startGuarding($callbackListener);
    }

    public function otherwise()
    {
        return new Responder();
    }

    private function denyAccess()
    {
        throw new AuthorizationException();
    }
}
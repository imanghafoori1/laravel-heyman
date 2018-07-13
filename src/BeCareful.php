<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;

class BeCareful
{
    public function toBeAuthorized()
    {
        $predicate = app(YouShouldHave::class)->predicate;

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
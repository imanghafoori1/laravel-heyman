<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Imanghafoori\HeyMan\Facades\HeyMan;

class GateAuthorizationTest extends TestCase
{
    public function testGate()
    {
        setUp::run();

        Gate::define('helloGate', function ($user, $bool, $yool) {
            return $yool;
        });

        HeyMan::whenEventHappens('myEvent')->thisGateShouldAllow('helloGate', false, false)->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('myEvent');
    }

    public function testGateAsMethod()
    {
        setUp::run();

        HeyMan::whenEventHappens('myEvent')->thisGateShouldAllow('Gates@helloGate', false)->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('myEvent');
    }

    public function testInlineGate()
    {
        setUp::run();

        $gate = function ($user, $booleanFlag) {
            return $booleanFlag;
        };
        HeyMan::whenEventHappens('myEvent')->thisGateShouldAllow($gate, false)->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('myEvent');
    }
}

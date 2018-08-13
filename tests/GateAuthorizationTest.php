<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\WatchingStrategies\EventManager;

class GateAuthorizationTest extends TestCase
{
    public function testGate()
    {
        Gate::define('helloGate', function ($user, $param1, $false) {
            return $false;
        });

        HeyMan::whenEventHappens('myEvent')->thisGateShouldAllow('helloGate', 'param1', false)->otherwise()->weDenyAccess();
        app(EventManager::class)->start();

        $this->expectException(AuthorizationException::class);

        event('myEvent');
    }

    public function testGateAsMethod()
    {
        HeyMan::whenEventHappens('myEvent')->thisGateShouldAllow('Gates@helloGate', false)->otherwise()->weDenyAccess();
        app(EventManager::class)->start();

        $this->expectException(AuthorizationException::class);

        event('myEvent');
    }

    public function testInlineGate()
    {
        $gate = function ($user, $booleanFlag) {
            return $booleanFlag;
        };

        HeyMan::whenEventHappens('myEvent')->thisGateShouldAllow($gate, false)->otherwise()->weDenyAccess();
        app(EventManager::class)->start();

        $this->expectException(AuthorizationException::class);

        event('myEvent');
    }
}

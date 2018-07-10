<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EventsAuthorizationTest extends TestCase
{
    public function testEventIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenEventHappens('myEvent4')->youShouldHaveRole('reader')->beCareful();

        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }

    public function testEventIsAuthorized2()
    {
        setUp::run($this);

        Gate::define('deadEnd', function () {
            return false;
        });

        Gate::define('open', function () {
            return true;
        });

        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->youShouldPassGate('deadEnd')->beCareful();
        HeyMan::whenEventHappens('myEvent4')->youShouldPassGate('open')->beCareful();

        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }
}
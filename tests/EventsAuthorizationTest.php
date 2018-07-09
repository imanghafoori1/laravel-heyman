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


}
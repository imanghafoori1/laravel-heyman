<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class RouteAuthorizationTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl('welcome')->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl('welcome')->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenVisitingUrl('welcome2')->youShouldHaveRole('reader')->beCareful();

        $this->get('/welcome1')->assertSuccessful();
    }
}
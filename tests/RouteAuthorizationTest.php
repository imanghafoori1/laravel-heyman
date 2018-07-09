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
}
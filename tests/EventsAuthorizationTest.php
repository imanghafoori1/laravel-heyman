<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EventsAuthorizationTest extends TestCase
{
    public function testEventIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }

    public function testEventIsAuthorized2()
    {
        setUp::run();

        Gate::define('deadEnd', function () {
            return false;
        });

        Gate::define('open', function () {
            return true;
        });

        HeyMan::whenEventHappens(['myEvent', 'myEvent1'])->thisGateShouldAllow('deadEnd')->otherwise()->weDenyAccess();
        HeyMan::whenEventHappens('myEvent4')->thisGateShouldAllow('open')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('myEvent1');
    }

    public function _testAlways()
    {
        setUp::run();
        HeyMan::whenEventHappens(['my-event', 'myEvent1'])->youShouldAlways()->abort(402);

        $this->get('event/my-event')->assertStatus(402);
    }

    public function _testAlways1()
    {
        setUp::run();
        HeyMan::whenEventHappens(['my-event', 'myEvent1'])->youShouldAlways()->redirect()->to('welcome');

        $this->get('event/my-event')->assertStatus(302)->assertRedirect('welcome');
    }
}

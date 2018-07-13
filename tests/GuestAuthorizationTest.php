<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class GuestAuthorizationTest extends TestCase
{
    public function testUrlIsNotAccessedByGuests3()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl('welcome')->youShouldBeGuest()->toBeAuthorized();
        HeyMan::whenVisitingUrl('welcome1')->youShouldBeGuest()->toBeAuthorized();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsNotAccessedByGuests4()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenVisitingUrl('welcome')->youShouldBeGuest()->toBeAuthorized();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsNotAccessedByGuests1()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl(['welcome', 'welcome_'])->youShouldBeGuest()->toBeAuthorized();
        HeyMan::whenVisitingUrl('welcome1')->youShouldBeGuest()->toBeAuthorized();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsNotAccessedByGuests()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl(['welcome_', 'welcome',])->youShouldBeGuest()->toBeAuthorized();
        HeyMan::whenVisitingUrl('welcome1')->youShouldBeGuest()->toBeAuthorized();

        $this->get('welcome')->assertStatus(403);
    }
}
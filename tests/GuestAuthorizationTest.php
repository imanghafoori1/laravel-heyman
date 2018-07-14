<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class GuestAuthorizationTest extends TestCase
{
    public function testUrlIsNotAccessedByGuests3()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl('welcome')->youShouldBeGuest()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsNotAccessedByGuests4()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsNotAccessedByGuests1()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->youShouldBeGuest()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsNotAccessedByGuests()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome',])->youShouldBeGuest()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }
}
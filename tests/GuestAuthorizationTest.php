<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class GuestAuthorizationTest extends TestCase
{
    public function testUrlIsNotAccessedByGuests3()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        $this->userIsNotGuest();

        HeyMan::whenYouVisitUrl('welcome')->youShouldBeGuest()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsNotAccessedByGuests2()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        $this->userIsNotGuest();

        HeyMan::whenYouReachRoute('welcome.name')->youShouldBeGuest()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsNotAccessedByGuests7()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        $this->userIsNotGuest();

        HeyMan::whenYouVisitUrl('welcome')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouReachRoute('welcome.*')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsNotAccessedByGuests4()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        $this->userIsGuest();

        HeyMan::whenYouVisitUrl('welcome')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsNotAccessedByGuests1()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        $this->userIsNotGuest();

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->youShouldBeGuest()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function test_the_order_of_urls_does_not_matter()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        $this->userIsNotGuest();

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->youShouldBeGuest()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldBeGuest()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    private function userIsNotGuest()
    {
        Auth::shouldReceive('guest')->andReturn(false);
    }

    private function userIsGuest(): void
    {
        Auth::shouldReceive('guest')->andReturn(true);
    }
}

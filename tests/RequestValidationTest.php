<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class RequestValidationTest extends TestCase
{
    public function testUrlIsNotAccessedWithInValidRequest()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);
        HeyMan::whenYouVisitUrl('welcome')->youShouldBeLoggedIn()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(302);
    }

    public function testUrlIsNotAccessedWithInValidRequestInOrder()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')->youShouldBeLoggedIn()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIs()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(function () {
            return ['name' => 'required'];
        });

        $this->get('welcome')->assertStatus(302);
    }
}

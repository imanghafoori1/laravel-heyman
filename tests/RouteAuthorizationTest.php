<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class RouteAuthorizationTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouVisitUrl('/welco*')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testPostUrls()
    {
        Route::post('/post', function () {
        });

        HeyMan::whenYouSendPost('post')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->post('post')->assertStatus(403);
    }

    public function testPutUrls()
    {
        Route::put('put', function () {
        });

        HeyMan::whenYouSendPut('put')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->put('put')->assertStatus(403);
    }

    public function testPatchUrls()
    {
        Route::patch('patch', function () {
        });

        HeyMan::whenYouSendPatch('patch')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->patch('patch')->assertStatus(403);
    }

    public function testDeleteUrls()
    {
        Route::patch('/delete', function () {
        });

        HeyMan::whenYouSendDelete('delete')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->delete('delete')->assertStatus(405);
    }

    public function testwhenYouVisitUrlCanAcceptArray()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized657()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized4563()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome', 'welcome_')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized563()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized4()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('/welcome', 'ewrf')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testUrlIsAuthorized1()
    {
        Route::get('/welcome1', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome2')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        $this->get('/welcome1')->assertSuccessful();
    }

    public function testUrlIsAuthorized2()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('/welcome')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testRouteNameIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouReachRoute('welcome.name')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouReachRoute('welcome1.name')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->get('welcome')->assertSuccessful();
    }

    public function testRouteNameIsAuthorized1()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouReachRoute('welcome.name')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->get('welcome')->assertStatus(403);
    }

    public function testRouteNameIsMatchWithPattern()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouReachRoute('welcome.*')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\HomeController@index')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized1()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\HomeController@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsAuthorized34()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouReachRoute(['welcome.name'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouReachRoute('welcome1.name')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertSuccessful();
    }

    public function testControllerActionIsAuthorized878()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouReachRoute('welcome.Oname')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('\HomeController@index')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized14()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('\\HomeController@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorizedWithPattern()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\\HomeController@*')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized134()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('MyController@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized154()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('MyController@*')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }
}

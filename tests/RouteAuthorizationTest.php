<?php

use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\MakeSure\Facades\MakeSure;

class RouteAuthorizationTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouVisitUrl('/welco*')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->statusCode(403);
    }

    public function testPostUrls()
    {
        Route::post('/post', function () {
        });

        HeyMan::whenYouSendPost('post')->always()->weDenyAccess();

        MakeSure::that($this)->sendingPostRequest('/post')->isRespondedWith()->statusCode(403);
    }

    public function testPutUrls()
    {
        Route::put('/put', function () {
        });

        HeyMan::whenYouSendPut('put')->always()->weDenyAccess()->then()
            ->terminateWith(function () {
                event('terminated_well');
            });
        $this->expectsEvents('terminated_well');
        $this->put('put')->assertStatus(403);
    }

    public function testPatchUrls()
    {
        Route::patch('/patch', function () {
        });

        HeyMan::whenYouSendPatch('patch')->always()->weDenyAccess();
        $this->patch('patch')->assertStatus(403);
    }

    public function testDeleteUrls()
    {
        Route::delete('/delete', function () {
        });

        HeyMan::whenYouSendDelete('delete')->always()->weDenyAccess();
        $this->delete('delete')->assertStatus(403);
    }

    public function testwhenYouVisitUrlCanAcceptArray()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testUrlIsAuthorized657()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testUrlIsAuthorized4563()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome', 'welcome_')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testUrlIsAuthorized563()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testUrlIsAuthorized4()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('/welcome', 'ewrf')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->always()->weDenyAccess();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testUrlIsAuthorized1()
    {
        Route::get('/welcome1', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome2')->always()->weDenyAccess();
        MakeSure::that($this)->sendingGetRequest('/welcome1')->isOk();
    }

    public function testUrlIsAuthorized2()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('/welcome')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->always()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouHitRouteName('welcome1.name')->always()->weDenyAccess();
        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameIsAuthorized1()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->always()->weDenyAccess();
        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testRouteNameIsMatchWithPattern()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.*')->always()->weDenyAccess();
        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testControllerActionIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\HomeController@index')->always()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testControllerActionIsAuthorized1()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\HomeController@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameIsAuthorized34()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName(['welcome.name'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouHitRouteName('welcome1.name')->always()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorized878()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.Oname')->always()->weDenyAccess();
        HeyMan::whenYouCallAction('\HomeController@index')->always()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testControllerActionIsAuthorized14()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('\\HomeController@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorizedWithPattern()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\\HomeController@*')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorized134()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('MyController@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorized154()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('MyController@*')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function test_urls_are_forgotten()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::forget()->aboutUrl(['welcome', 'welcome_']);
        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameIsAuthorizeda()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->always()->weDenyAccess();
        HeyMan::forget()->aboutRoute('welcome.name');
        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorized2()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\HomeController@index')->always()->weDenyAccess();
        HeyMan::forget()->aboutAction('\HomeController@index');

        MakeSure::that($this)->sendingGetRequest('/welcome')->isOk();
    }
}

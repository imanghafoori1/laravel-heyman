<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyManTests\Stubs\HomeController;
use Imanghafoori\MakeSure\Facades\MakeSure;

class RouteAuthorizationTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouVisitUrl('/welco*')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->statusCode(403);
    }

    public function testPostUrls()
    {
        Route::post('/post', function () {
        });

        HeyMan::whenYouSendPost('post')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingPostRequest('/post')->isRespondedWith()->statusCode(403);
    }

    public function testPutUrls()
    {
        Route::put('/put', function () {
        });

        HeyMan::whenYouSendPut('put')->always()->weDenyAccess()->then()
            ->terminateWith(function () {
                event('terminated_well');
            });

        Event::fake();
        app(StartGuarding::class)->start();
        $this->put('put')->assertStatus(403);
        Event::assertDispatched('terminated_well');
    }

    public function testPatchUrls()
    {
        Route::patch('/patch', function () {
        });

        HeyMan::whenYouSendPatch('patch')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->patch('patch')->assertStatus(403);
    }

    public function testDeleteUrls()
    {
        Route::delete('/delete', function () {
        });

        HeyMan::whenYouSendDelete('delete')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->delete('delete')->assertStatus(403);
    }

    public function testwhenYouVisitUrlCanAcceptArray()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testUrlIsAuthorized657()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testUrlIsAuthorized4563()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome', 'welcome_')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testUrlIsAuthorized563()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testUrlIsAuthorized4()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('/welcome', 'ewrf')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testUrlIsAuthorized1()
    {
        Route::get('/welcome1', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome2')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome1')->isOk();
    }

    public function testUrlIsAuthorized2()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('/welcome')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameIsAuthorized()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouHitRouteName('welcome1.name')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameIsAuthorized1()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testRouteNameIsMatchWithPattern()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.*')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testControllerActionIsAuthorized()
    {
        Route::get('/welcome', '\\'.HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\\'.HomeController::class.'@index')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testControllerActionIsAuthorized1()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouCallAction(HomeController::class.'@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameIsAuthorized34()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName(['welcome.name'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouHitRouteName('welcome1.name')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorized878()
    {
        Route::get('/welcome', '\\'.HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.Oname')->always()->weDenyAccess();
        HeyMan::whenYouCallAction('\\'.HomeController::class.'@index')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isRespondedWith()->forbiddenStatus();
    }

    public function testControllerActionIsAuthorized14()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('\HomeController::class.\@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorizedWithPattern()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouCallAction('\HomeController::class.\@*')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorized134()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('MyController@index')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testControllerActionIsAuthorized154()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouCallAction('MyController@*')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function test_urls_are_forgotten()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::forget()->aboutUrl(['welcome', 'welcome_']);
        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameIsAuthorizeda()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->always()->weDenyAccess();
        HeyMan::forget()->aboutRoute('welcome.name');
        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }

    public function testRouteNameConditionCanBeAliased()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::aliasSituation('whenYouHitRouteName', 'salam');

        HeyMan::salam('welcome.name')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->get('/welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized2()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouCallAction(HomeController::class.'@index')->always()->weDenyAccess();
        HeyMan::forget()->aboutAction(HomeController::class.'@index');

        app(StartGuarding::class)->start();
        MakeSure::about($this)->sendingGetRequest('/welcome')->isOk();
    }
}

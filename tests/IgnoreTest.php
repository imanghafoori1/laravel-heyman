<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyManTests\Stubs\HomeController;
use Imanghafoori\MakeSure\Facades\MakeSure;

class IgnoreTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouVisitUrl('/welco*')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        HeyMan::turnOff()->routeChecks();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized657()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        HeyMan::turnOff()->routeChecks();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized563()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        HeyMan::turnOff()->routeChecks();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized566()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        HeyMan::turnOff()->routeChecks();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsAuthorized1()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->always()->weDenyAccess();

        HeyMan::turnOff()->routeChecks();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsMatchWithPattern()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.*')->always()->weDenyAccess();

        HeyMan::turnOff()->routeChecks();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouCallAction(HomeController::class.'@index')->always()->weDenyAccess();

        HeyMan::turnOff()->routeChecks();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized878()
    {
        Route::get('/welcome', HomeController::class.'@index');

        HeyMan::whenYouCallAction(HomeController::class.'@index')->always()->weDenyAccess();

        HeyMan::turnOff()->routeChecks();
        app(StartGuarding::class)->start();

        $this->get('welcome')->assertStatus(200);
    }

    public function testFetchingModelsIsAuthorized_Ignorance()
    {
        HeyMan::whenYouFetch('\App\User')->always()->weDenyAccess();

        HeyMan::turnOff()->eloquentChecks();

        event('eloquent.retrieved: App\User');
        $this->assertTrue(true);
    }

    public function testEventAuthorized_Ignorance()
    {
        HeyMan::whenEventHappens('hey')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        HeyMan::turnOff()->eventChecks();

        event('hey');
        $this->assertTrue(true);
    }

    public function testFetchingModelsIsAuthorized_closure_Ignorance()
    {
        HeyMan::whenYouFetch('\App\User')->always()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->always()->weDenyAccess();

        config()->set('heyman_ignore_eloquent', '2222');

        HeyMan::turnOff()->eloquentChecks(function () {
            event('eloquent.retrieved: App\User');
        });

        $this->assertEquals(config('heyman_ignore_eloquent'), '2222');
    }

    public function testViewIsAuthorized21134()
    {
        HeyMan::whenYouMakeView(['welcome', 'errors.503'])
            ->thisValueShouldAllow(false)
            ->otherwise()
            ->weDenyAccess();
        app(StartGuarding::class)->start();
        HeyMan::turnOff()->viewChecks();

        view('welcome');
        $this->assertTrue(true);
    }

    public function testViewIsAuthorized2134()
    {
        HeyMan::whenYouMakeView(['welcome', 'errors.503'])
            ->thisValueShouldAllow(false)
            ->otherwise()
            ->weDenyAccess();
        app(StartGuarding::class)->start();
        HeyMan::turnOff()->allChecks();

        view('welcome');
        $this->assertTrue(true);
    }

    public function test_check_would_be_turned_On_again()
    {
        Route::put('put', function () {
        });
        HeyMan::whenYouSendPut('put')->always()->weDenyAccess();

        HeyMan::turnOff()->allChecks();
        HeyMan::turnOn()->allChecks();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingPutRequest('put')->isRespondedWith()->statusCode(403);
    }

    public function test_it_ignores_validation()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);

        HeyMan::turnOff()->validationChecks();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('welcome')->isRespondedWith()->statusCode(200);
    }

    public function test_it_ignores_validation2()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')
            ->yourRequestShouldBeValid(['name' => 'required'])
            ->otherwise()
            ->response()->json(['oh oh'], 400);

        HeyMan::turnOff()->validationChecks();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('welcome')->isRespondedWith()->statusCode(200);
    }

    public function test_it_ignores_validation3()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);

        HeyMan::turnOff()->allChecks();
        app(StartGuarding::class)->start();

        MakeSure::about($this)->sendingGetRequest('welcome')->isRespondedWith()->statusCode(200);
    }
}

<?php

use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyMan\Facades\HeyMan;

class IgnoreTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouVisitUrl('/welco*')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized657()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized563()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->always()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsAuthorized1()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->always()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsMatchWithPattern()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.*')->always()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouCallAction('\HomeController@index')->always()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized878()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouCallAction('\HomeController@index')->always()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testFetchingModelsIsAuthorized_Ignorance()
    {
        HeyMan::whenYouFetch('\App\User')->always()->weDenyAccess();

        Heyman::turnOff()->eloquentChecks();

        event('eloquent.retrieved: App\User');
        $this->assertTrue(true);
    }

    public function testEventAuthorized_Ignorance()
    {
        HeyMan::whenEventHappens('hey')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        Heyman::turnOff()->eventChecks();

        event('hey');
        $this->assertTrue(true);
    }

    public function testFetchingModelsIsAuthorized_closure_Ignorance()
    {
        HeyMan::whenYouFetch('\App\User')->always()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->always()->weDenyAccess();

        config()->set('heyman_ignore_eloquent', '2222');

        Heyman::turnOff()->eloquentChecks(function () {
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
        Heyman::turnOff()->viewChecks();

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
        Heyman::turnOff()->allChecks();

        view('welcome');
        $this->assertTrue(true);
    }

    public function test_check_would_be_turned_On_again()
    {
        Route::put('put', function () {
        });
        HeyMan::whenYouSendPut('put')->always()->weDenyAccess();

        Heyman::turnOff()->allChecks();
        Heyman::turnOn()->allChecks();

        MakeSure::that($this)->sendingPutRequest('put')->isRespondedWith()->statusCode(403);
    }

    public function test_it_ignores_validation()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);

        HeyMan::turnOff()->validationChecks();

        MakeSure::that($this)->sendingGetRequest('welcome')->isRespondedWith()->statusCode(200);
    }

    public function test_it_ignores_validation2()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);

        HeyMan::turnOff()->allChecks();

        MakeSure::that($this)->sendingGetRequest('welcome')->isRespondedWith()->statusCode(200);
    }
}

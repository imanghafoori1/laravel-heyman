<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class RouteAuthorizationIgnoreTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('/welco*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testwhenYouVisitUrlCanAcceptArray()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized657()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized4563()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('welcome', 'welcome_')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized563()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouVisitRoute('welcome.name')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsMatchWithPattern()
    {
        setUp::run();

        HeyMan::whenYouVisitRoute('welcome.*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouCallAction('\HomeController@index')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized878()
    {
        setUp::run();

        HeyMan::whenYouVisitRoute('welcome.Oname')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('\HomeController@index')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        Heyman::ignore()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testFetchingModelsIsAuthorized_Ignorance()
    {
        setUp::run();

        HeyMan::whenYouFetch('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        Heyman::ignore()->eloquentChecks();

        event('eloquent.retrieved: App\User');
    }

    public function testViewIsAuthorized21134()
    {
        setUp::run();

        HeyMan::whenYouMakeView(['welcome', 'errors.503'])
            ->youShouldHaveRole('reader')
            ->otherwise()
            ->weDenyAccess();

        Heyman::ignore()->viewChecks();

        view('welcome');
    }
}

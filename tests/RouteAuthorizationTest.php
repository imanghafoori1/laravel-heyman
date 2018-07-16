<?php

use Illuminate\Support\Str;
use Imanghafoori\HeyMan\Facades\HeyMan;

class RouteAuthorizationTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl('welco*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testwhenYouVisitUrlCanAcceptArray()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized657()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome',])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized4563()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl('welcome', 'welcome_')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized563()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized4()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl('welcome', 'ewrf')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testUrlIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome2')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('/welcome1')->assertSuccessful();
    }

    public function testUrlIsAuthorized2()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl('welcome')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testRouteNameIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenVisitingRoute('welcome.name')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenVisitingRoute('welcome1.name')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        $this->get('welcome')->assertSuccessful();
    }

    public function testRouteNameIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenVisitingRoute('welcome.name')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        $this->get('welcome')->assertStatus(403);
    }

    public function testRouteNameIsMatchWithPattern()
    {
        setUp::run($this);

        HeyMan::whenVisitingRoute('welcome.*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenCallingAction(HomeController::class.'@index')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenCallingAction(HomeController::class.'@index')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsAuthorized34()
    {
        setUp::run($this);

        HeyMan::whenVisitingRoute(['welcome.name'])->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenVisitingRoute('welcome1.name')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        $this->get('welcome')->assertSuccessful();
    }

    public function testControllerActionIsAuthorized878()
    {
        setUp::run($this);

        HeyMan::whenVisitingRoute('welcome.Oname')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenCallingAction(HomeController::class.'@index')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized14()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenCallingAction(HomeController::class.'@index')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }
}
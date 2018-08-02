<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class RouteAuthorizationTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('/welco*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testPostUrls()
    {
        setUp::run();
        HeyMan::whenYouSendPost('post')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->post('post')->assertStatus(403);
    }

    public function testPutUrls()
    {
        setUp::run();
        HeyMan::whenYouSendPut('put')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->put('put')->assertStatus(404);
    }

    public function testPatchUrls()
    {
        setUp::run();
        HeyMan::whenYouSendPatch('patch')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->patch('patch')->assertStatus(403);
    }

    public function testDeleteUrls()
    {
        setUp::run();
        HeyMan::whenYouSendDelete('delete')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        $this->delete('delete')->assertStatus(405);
    }

    public function testwhenYouVisitUrlCanAcceptArray()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized657()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized4563()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('welcome', 'welcome_')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized563()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized4()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('/welcome', 'ewrf')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testUrlIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome2')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('/welcome1')->assertSuccessful();
    }

    public function testUrlIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl('/welcome')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testRouteNameIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouReachRoute('welcome.name')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouReachRoute('welcome1.name')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        $this->get('welcome')->assertSuccessful();
    }

    public function testRouteNameIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouReachRoute('welcome.name')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        $this->get('welcome')->assertStatus(403);
    }

    public function testRouteNameIsMatchWithPattern()
    {
        setUp::run();

        HeyMan::whenYouReachRoute('welcome.*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouCallAction('\HomeController@index')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouCallAction('\HomeController@index')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsAuthorized34()
    {
        setUp::run();

        HeyMan::whenYouReachRoute(['welcome.name'])->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouReachRoute('welcome1.name')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        $this->get('welcome')->assertSuccessful();
    }

    public function testControllerActionIsAuthorized878()
    {
        setUp::run();

        HeyMan::whenYouReachRoute('welcome.Oname')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('\HomeController@index')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized14()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('\\HomeController@index')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorizedWithPattern()
    {
        setUp::run();

        HeyMan::whenYouCallAction('\\HomeController@*')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized134()
    {
        setUp::run();

        HeyMan::whenYouVisitUrl(['welcom2', 'ewrf'])->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouCallAction('MyController@index')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized154()
    {
        setUp::run();

        HeyMan::whenYouCallAction('MyController@*')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(200);
    }
}

<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class OtherwiseTest extends TestCase
{
    public function testOtherwise()
    {
        setUp::run($this);
        HeyMan::whenVisitingUrl('welcome')->youShouldHaveRole('reader')->otherwise()->redirectTo('home');

        $this->get('welcome')->assertRedirect('home');
    }

    public function testOtherwise1()
    {
        setUp::run($this);
        HeyMan::whenYouSeeViewFile('welcome')->youShouldBeGuest()->otherwise()->redirectTo('home');

        $this->get('welcome')->assertRedirect('home');
    }

    public function testOtherwise3()
    {
        setUp::run($this);
        auth()->logout();
        HeyMan::whenYouSeeViewFile('welcome')->youShouldBeGuest()->otherwise()->redirectTo('home');

        $this->get('welcome')->assertStatus(200);
    }

    public function testOtherwise4()
    {
        setUp::run($this);
        HeyMan::whenYouSeeViewFile('welcome')->youShouldHaveRole('writer')->otherwise()->throwNew(\Illuminate\Auth\Access\AuthorizationException::class);

        $this->get('welcome')->assertStatus(200);
    }

    public function testAbort()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl(['welcome', 'welcome_'])->youShouldHaveRole('reader')->otherwise()->json(['m'=> 'm'], 403);
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertJson(['m'=>'m'])->assertStatus(403);
        $this->get('welcome1')->assertStatus(200);
    }

    public function testAbort1()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl('welcome', 'asdfv')->youShouldHaveRole('reader')->otherwise()->abort(405);
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertStatus(405);
        $this->get('welcome1')->assertStatus(200);
    }

    public function _testWhenVisitingUrlCanAcceptArray()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl(['welcome', 'welcome_'])->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertStatus(403);
    }

    public function _testUrlIsAuthorized657()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl(['welcome_', 'welcome',])->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertStatus(403);
    }
}
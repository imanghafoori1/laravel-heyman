<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class OtherwiseTest extends TestCase
{
    public function testOtherwise()
    {
        setUp::run($this);
        HeyMan::whenYouVisitUrl('welcome')->youShouldHaveRole('reader')->otherwise()->redirectTo('home');

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

        HeyMan::whenYouVisitUrl(['welcome', 'welcome_'])->youShouldHaveRole('reader')->otherwise()->json(['m'=> 'm'], 403);
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertJson(['m'=>'m'])->assertStatus(403);
        $this->get('welcome1')->assertStatus(200);
    }

    public function testAbort1()
    {
        setUp::run($this);

        HeyMan::whenYouVisitUrl('welcome', 'asdfv')->youShouldHaveRole('reader')->otherwise()->abort(405);
        HeyMan::whenYouVisitUrl('welcome1')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(405);
        $this->get('welcome1')->assertStatus(200);
    }
}
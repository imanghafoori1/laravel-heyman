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
        HeyMan::whenYouSeeViewFile('welcome')->youShouldHaveRole('reader')->otherwise()->redirectTo('home');

        $this->get('welcome')->assertRedirect('home');
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
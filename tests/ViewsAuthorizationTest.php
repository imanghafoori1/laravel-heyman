<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class ViewsAuthorizationTest extends TestCase
{
    public function testViewIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenYouSeeViewFile('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2134()
    {
        setUp::run($this);

        HeyMan::whenYouSeeViewFile(['welcome'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouSeeViewFile(['welcome1'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized34()
    {
        setUp::run($this);

        HeyMan::whenViewMake('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized21134()
    {
        setUp::run($this);

        HeyMan::whenViewMake(['welcome', 'errors.503'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2174()
    {
        setUp::run($this);

        HeyMan::whenViewMake('welcome', 'errors.503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }
}
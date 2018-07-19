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

        HeyMan::whenYouViewBlade('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized21134()
    {
        setUp::run($this);

        HeyMan::whenYouViewBlade(['welcome', 'errors.503'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2174()
    {
        setUp::run($this);

        HeyMan::whenYouViewBlade('welcome', 'errors.503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized2674()
    {
        setUp::run($this);

        HeyMan::whenYouViewBlade('errors/503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors/503');
    }

    public function testViewIsAuthorized274()
    {
        setUp::run($this);

        HeyMan::whenYouViewBlade('errors.*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }


    public function testViewIsAuthorized24()
    {
        setUp::run($this);

        HeyMan::whenYouViewBlade('*.503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }
}
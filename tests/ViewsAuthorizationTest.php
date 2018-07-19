<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class ViewsAuthorizationTest extends TestCase
{
    public function testViewIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouSeeViewFile('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2134()
    {
        setUp::run();

        HeyMan::whenYouSeeViewFile(['welcome'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouSeeViewFile(['errors.503'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized34()
    {
        setUp::run();

        HeyMan::whenYouViewBlade('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized21134()
    {
        setUp::run();

        HeyMan::whenYouViewBlade(['welcome', 'errors.503'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2174()
    {
        setUp::run();

        HeyMan::whenYouViewBlade('welcome', 'errors.503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized2674()
    {
        setUp::run();

        HeyMan::whenYouViewBlade('errors/503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors/503');
    }

    public function testViewIsAuthorized274()
    {
        setUp::run();

        HeyMan::whenYouViewBlade('errors.*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }


    public function testViewIsAuthorized24()
    {
        setUp::run();

        HeyMan::whenYouViewBlade('*.503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized2130()
    {
        setUp::run();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('View [nonExistingView] not found.');

        HeyMan::whenYouSeeViewFile(['nonExistingView'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
    }
}
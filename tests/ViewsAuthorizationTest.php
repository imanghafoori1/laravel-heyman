<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class ViewsAuthorizationTest extends TestCase
{
    public function testViewIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouMakeView('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2134()
    {
        setUp::run();

        HeyMan::whenYouMakeView(['welcome'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouMakeView(['errors.503'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized34()
    {
        setUp::run();

        HeyMan::whenYouMakeView('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized21134()
    {
        setUp::run();

        HeyMan::whenYouMakeView(['welcome', 'errors.503'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2174()
    {
        setUp::run();

        HeyMan::whenYouMakeView('welcome', 'errors.503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized2674()
    {
        setUp::run();

        HeyMan::whenYouMakeView('errors/503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors/503');
    }

    public function testViewIsAuthorized274()
    {
        setUp::run();

        HeyMan::whenYouMakeView('errors.*')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }


    public function testViewIsAuthorized24()
    {
        setUp::run();

        HeyMan::whenYouMakeView('*.503')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized2130()
    {
        setUp::run();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('View [nonExistingView] not found.');

        HeyMan::whenYouMakeView(['nonExistingView'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
    }
}
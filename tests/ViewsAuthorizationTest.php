<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\WatchingStrategies\ViewEventManager;

class ViewsAuthorizationTest extends TestCase
{
    public function testViewIsAuthorized()
    {
        HeyMan::whenYouMakeView('welcome')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        app(ViewEventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2134()
    {
        HeyMan::whenYouMakeView(['welcome'])->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouMakeView(['errors.503'])->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        app(ViewEventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized34()
    {
        HeyMan::whenYouMakeView('welcome')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(ViewEventManager::class)->start();
        view('welcome');
        $this->assertTrue(true);
    }

    public function testViewIsAuthorized21134()
    {
        HeyMan::whenYouMakeView(['welcome', 'errors.503'])->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        app(ViewEventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2174()
    {
        HeyMan::whenYouMakeView('welcome', 'errors/503')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        app(ViewEventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function test_views_are_normalized()
    {
        HeyMan::whenYouMakeView('errors/503')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        app(ViewEventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized274()
    {
        HeyMan::whenYouMakeView('errors.*')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        app(ViewEventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized24()
    {
        HeyMan::whenYouMakeView('*.503')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        app(ViewEventManager::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function test_view_is_checked_for_existence()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('View [nonExistingView] not found.');

        HeyMan::whenYouMakeView(['nonExistingView'])->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
    }
}

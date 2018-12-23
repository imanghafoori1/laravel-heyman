<?php

use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Illuminate\Auth\Access\AuthorizationException;

class ViewsAuthorizationTest extends TestCase
{
    public function testViewIsAuthorized()
    {
        HeyMan::whenYouMakeView('welcome')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2134()
    {
        HeyMan::whenYouMakeView(['welcome'])->always()->weDenyAccess();
        HeyMan::whenYouMakeView(['errors.503'])->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized34()
    {
        HeyMan::whenYouMakeView('welcome')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        view('welcome');
        $this->assertTrue(true);
    }

    public function testViewIsAuthorized21134()
    {
        HeyMan::whenYouMakeView(['welcome', 'errors.503'])->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testViewIsAuthorized2174()
    {
        HeyMan::whenYouMakeView('welcome', 'errors/503')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function test_views_are_normalized()
    {
        HeyMan::whenYouMakeView('errors/503')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized274()
    {
        HeyMan::whenYouMakeView('errors.*')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function testViewIsAuthorized24()
    {
        HeyMan::whenYouMakeView('*.503')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }

    public function test_view_is_checked_for_existence()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('View [nonExistingView] not found.');

        HeyMan::whenYouMakeView(['nonExistingView'])->always()->weDenyAccess();
    }

    public function test_View_Is_Forgotten_To_Be_Authorized()
    {
        HeyMan::whenYouMakeView('welcome', 'errors/503')->always()->weDenyAccess();
        HeyMan::forget()->aboutView('welcome', 'errors/503');

        app(StartGuarding::class)->start();

        view('errors.503');
        $this->assertTrue(true);
    }

    public function test_View_Is_Forgotten_To_Be_Authorized2()
    {
        HeyMan::whenYouMakeView('welcome')->always()->weDenyAccess();
        HeyMan::forget()->aboutView('welcome', 'errors/503');

        app(StartGuarding::class)->start();

        view('welcome');
        $this->assertTrue(true);
    }

    public function test_View_Is_Forgotten_To_Be_Authorized3()
    {
        HeyMan::whenYouMakeView('welcome', 'errors/503')->always()->weDenyAccess();
        HeyMan::whenYouMakeView('welcome', 'errors/503')->always()->weThrowNew(AuthorizationException::class);
        HeyMan::forget()->aboutView(['welcome', 'errors/503']);

        app(StartGuarding::class)->start();

        view('errors.503');
        view('welcome');
        $this->assertTrue(true);
    }

    public function test_View_Is_Forgotten_To_Be_Authorized4()
    {
        HeyMan::whenYouMakeView('welcome', 'errors/503')->always()->weDenyAccess();
        HeyMan::forget()->aboutView('welcome1');

        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        view('errors.503');
    }
}

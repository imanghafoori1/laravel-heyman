<?php

use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Illuminate\Auth\Access\AuthorizationException;

class EloquentAuthorizationTest extends TestCase
{
    public function testCreatingModelsIsAuthorized()
    {
        \HeyMan::whenYouCreate('\App\User')->always()->weDenyAccess();
        \HeyMan::whenYouCreate('\App\User2')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        $this->expectException(AuthorizationException::class);

        event('eloquent.creating: App\User', new \App\User());
    }

    public function testUpdatingModelsIsAuthorized()
    {
        Gate::shouldReceive('allows')->with('heyman.youShouldHaveRole', ['writer', 'payload'])->andReturn(true);

        HeyMan::whenYouUpdate('\App\User')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        event('eloquent.updating: App\User', 'payload');
        $this->assertTrue(true);
    }

    public function testUpdatingModelsIsAuthorized2()
    {
        HeyMan::whenYouUpdate('\App\User')->thisClosureShouldAllow(function ($param, $param2, $user) {
            return ! ($param === 1 and $param2 === 2 and (is_a($user, \App\User::class)));
        }, [1, 2])->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.updating: App\User', new \App\User());
    }

    public function testSavingModelsIsAuthorized2()
    {
        HeyMan::whenYouSave('\App\User')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: App\User');
    }

    public function testSavingModelsIsAuthorized3()
    {
        HeyMan::whenYouSave('\App\User')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: App\User');
    }

    public function testSavingModelsIsAuthorized1()
    {
        HeyMan::whenYouSave('\App\User')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: App\User');
    }

    public function testSavingModelsIsAuthorized36()
    {
        HeyMan::whenYouSave('\App\User')->always()->weDenyAccess();
        HeyMan::forget()->aboutSaving(['\App\User']);
        app(StartGuarding::class)->start();

        event('eloquent.saving: App\User');
        $this->assertTrue(true);
    }

    public function testDeletingModelsIsAuthorized1()
    {
        HeyMan::whenYouDelete('\App\User')->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.deleting: App\User');
    }

    public function testDeletingModelsIsAuthorized4()
    {
        HeyMan::whenYouDelete('\App\User')->always()->weDenyAccess();
        HeyMan::forget()->aboutDeleting(['\App\User']);
        app(StartGuarding::class)->start();
        event('eloquent.deleting: App\User');
        $this->assertTrue(true);
    }

    public function testDeletingModelsIsAuthorized9()
    {
        HeyMan::whenYouSave('\App\User')->always()->weDenyAccess();
        HeyMan::whenYouDelete('\App\User')->always()->weDenyAccess();

        HeyMan::forget()->aboutDeleting(['\App\User']);
        app(StartGuarding::class)->start();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);
        event('eloquent.deleting: App\User');
        event('eloquent.saving: App\User');
    }

    public function testDeletingModelsIsAuthorized2()
    {
        HeyMan::whenYouDelete(['\App\User'])->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);
        event('eloquent.deleting: App\User');
    }

    public function testFetchingModelsIsAuthorized()
    {
        HeyMan::whenYouFetch('\App\User')->always()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        $this->expectException(AuthorizationException::class);

        event('eloquent.retrieved: App\User');
    }

    public function testFetchingModelsIgnored()
    {
        HeyMan::whenYouFetch(\App\User::class)->always()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->always()->weDenyAccess();
        HeyMan::forget()->aboutModel(\App\User::class);
        app(StartGuarding::class)->start();

        event('eloquent.retrieved: App\User');
        $this->assertTrue(true);
    }

    public function testFetchingModelsIgnored2()
    {
        HeyMan::whenYouFetch(\App\User::class)->always()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->always()->weDenyAccess();
        HeyMan::forget()->aboutFetching(\App\User::class);
        app(StartGuarding::class)->start();

        event('eloquent.retrieved: App\User');
        $this->assertTrue(true);
    }

    public function _testHeyWait()
    {

     /*   HeyWait::byNow()
            ->youShouldBeloggedIn()
            ->otherwise()
            ->redirectBack();


        HeyWait::ifYouAreLoggedIn()->redirectBack();
        HeyWait::ifGateDenies('')->redirectBack();

        HeyWait::ifIsFalsy(function () {
            return false;
        })->redirectBack();

        HeyWait::ifIsFalse(auth()->guest())
            ->redirect('/home');

        MakeSure::that()
            ->whenYouVisit('admin/article')
            ->asGuest()
            ->youWillBeRedirectedTo('/login');*/
    }
}

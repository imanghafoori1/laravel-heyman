<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Support\Facades\Gate;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyManTests\Stubs\User;
use Imanghafoori\HeyManTests\Stubs\User2;
use Illuminate\Auth\Access\AuthorizationException;

class EloquentAuthorizationTest extends TestCase
{
    public function testCreatingModelsIsAuthorized()
    {
        \HeyMan::whenYouCreate(User::class)->always()->weDenyAccess();
        \HeyMan::whenYouCreate(User2::class)->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        $this->expectException(AuthorizationException::class);

        event('eloquent.creating: '.User::class, new User());
    }

    public function testCreatingCanBeAliased()
    {
        \HeyMan::aliasSituation('whenYouCreate', 'salam');
        \HeyMan::salam(User::class)->always()->weDenyAccess();
        \HeyMan::salam(User2::class)->always()->weDenyAccess();

        app(StartGuarding::class)->start();

        $this->expectException(AuthorizationException::class);

        event('eloquent.creating: '.User::class, new User());
    }

    public function testUpdatingModelsIsAuthorized()
    {
        Gate::shouldReceive('allows')->with('heyman.youShouldHaveRole', ['writer', 'payload'])->andReturn(true);

        HeyMan::whenYouUpdate(User::class)->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate(User2::class)->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        event('eloquent.updating: '.User::class, 'payload');
        $this->assertTrue(true);
    }

    public function testUpdatingModelsIsAuthorized2()
    {
        HeyMan::whenYouUpdate(User::class)->thisClosureShouldAllow(function ($param, $param2, $user) {
            return ! ($param === 1 and $param2 === 2 and (is_a($user, User::class)));
        }, [1, 2])->otherwise()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.updating: '.User::class, new User());
    }

    public function testSavingModelsIsAuthorized2()
    {
        HeyMan::whenYouSave(User::class)->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.User::class);
    }

    public function testSavingModelsIsAuthorized3()
    {
        HeyMan::whenYouSave(User::class)->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.User::class);
    }

    public function testSavingModelsIsAuthorized1()
    {
        HeyMan::whenYouSave(User::class)->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.User::class);
    }

    public function testSavingModelsIsAuthorized36()
    {
        HeyMan::whenYouSave(User::class)->always()->weDenyAccess();
        HeyMan::forget()->aboutSaving([User::class]);
        app(StartGuarding::class)->start();

        event('eloquent.saving: '.User::class);
        $this->assertTrue(true);
    }

    public function testDeletingModelsIsAuthorized1()
    {
        HeyMan::whenYouDelete(User::class)->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.deleting: '.User::class);
    }

    public function testDeletingModelsIsAuthorized4()
    {
        HeyMan::whenYouDelete(User::class)->always()->weDenyAccess();
        HeyMan::forget()->aboutDeleting([User::class]);
        app(StartGuarding::class)->start();
        event('eloquent.deleting: '.User::class);
        $this->assertTrue(true);
    }

    public function testDeletingModelsIsAuthorized9()
    {
        HeyMan::whenYouSave(User::class)->always()->weDenyAccess();
        HeyMan::whenYouDelete(User::class)->always()->weDenyAccess();

        HeyMan::forget()->aboutDeleting([User::class]);
        app(StartGuarding::class)->start();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);
        event('eloquent.deleting: '.User::class);
        event('eloquent.saving: '.User::class);
    }

    public function testDeletingModelsIsAuthorized2()
    {
        HeyMan::whenYouDelete([User::class])->always()->weDenyAccess();
        app(StartGuarding::class)->start();
        $this->expectException(AuthorizationException::class);
        event('eloquent.deleting: '.User::class);
    }

    public function testFetchingModelsIsAuthorized()
    {
        HeyMan::whenYouFetch(User::class)->always()->weDenyAccess();
        HeyMan::whenYouCreate(User2::class)->always()->weDenyAccess();
        app(StartGuarding::class)->start();

        $this->expectException(AuthorizationException::class);

        event('eloquent.retrieved: '.User::class);
    }

    public function testFetchingModelsIgnored()
    {
        HeyMan::whenYouFetch(User::class)->always()->weDenyAccess();
        HeyMan::whenYouCreate(User2::class)->always()->weDenyAccess();
        HeyMan::forget()->aboutModel(User::class);
        app(StartGuarding::class)->start();

        event('eloquent.retrieved: '.User::class);
        $this->assertTrue(true);
    }

    public function testFetchingModelsIgnored2()
    {
        HeyMan::whenYouFetch(User::class)->always()->weDenyAccess();
        HeyMan::whenYouCreate(User2::class)->always()->weDenyAccess();
        HeyMan::forget()->aboutFetching(User::class);
        app(StartGuarding::class)->start();

        event('eloquent.retrieved: '.User::class);
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

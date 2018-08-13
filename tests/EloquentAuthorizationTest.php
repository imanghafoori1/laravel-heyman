<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentEventsManager;

class EloquentAuthorizationTest extends TestCase
{
    public function testCreatingModelsIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouCreate('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();

        $this->expectException(AuthorizationException::class);

        event('eloquent.creating: App\User', new \App\User());
    }

    public function testUpdatingModelsIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouUpdate('\App\User')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();

        event('eloquent.updating: App\User', 'payload');
        $this->assertTrue(true);
    }

    public function testUpdatingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouUpdate('\App\User')->thisClosureShouldAllow(function ($param, $param2, $user) {
            return !($param === 1 and $param2 === 2 and (is_a($user, \App\User::class)));
        }, [1, 2])->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.updating: App\User', new \App\User());
    }

    public function testSavingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouSave('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: App\User');
    }

    public function testSavingModelsIsAuthorized3()
    {
        setUp::run();

        HeyMan::whenYouSave('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: App\User');
    }

    public function testSavingModelsIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouSave('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: App\User');
    }

    public function testDeletingModelsIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouDelete('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();
        $this->expectException(AuthorizationException::class);

        event('eloquent.deleting: App\User');
    }

    public function testDeletingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouDelete(['\App\User'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();
        $this->expectException(AuthorizationException::class);
        event('eloquent.deleting: App\User');
    }

    public function testFetchingModelsIsAuthorized()
    {
        //     setUp::run();

        HeyMan::whenYouFetch('\App\User')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        app(EloquentEventsManager::class)->start();

        $this->expectException(AuthorizationException::class);

        event('eloquent.retrieved: App\User');
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

        HeyMan::makeSure()
            ->whenYouVisit('admin/article')
            ->asGuest()
            ->youWillBeRedirectedTo('/login');*/
    }
}

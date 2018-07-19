<?php

use App\User;
use App\User2;
use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EloquentAuthorizationTest extends TestCase
{
    public function testCreatingModelsIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouCreate(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate(User2::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.creating: '.User::class);
    }

    public function testUpdatingModelsIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouUpdate(User::class)->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate(User2::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        event('eloquent.updating: '.User::class);
        $this->assertTrue(true);
    }

    public function testUpdatingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouUpdate(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.updating: '.User::class);
    }

    public function testSavingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouSave(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.User::class);
    }

    public function testSavingModelsIsAuthorized3()
    {
        setUp::run();

        HeyMan::whenYouSave(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.User::class);
    }

    public function testSavingModelsIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouSave(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.User::class);
    }

    public function testDeletingModelsIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouDelete(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.deleting: '.User::class);
    }

    public function testDeletingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouDelete([User::class])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.deleting: '.User::class);
    }

    public function testFetchingModelsIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouFetch(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate(User2::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.retrieved: '.User::class);
    }
}
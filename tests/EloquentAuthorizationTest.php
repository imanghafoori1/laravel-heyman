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

        HeyMan::whenYouCreate('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.creating: '.'\App\User');
    }

    public function testUpdatingModelsIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouUpdate('\App\User')->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        event('eloquent.updating: '.'\App\User');
        $this->assertTrue(true);
    }

    public function testUpdatingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouUpdate('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.updating: '.'\App\User');
    }

    public function testSavingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouSave('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.'\App\User');
    }

    public function testSavingModelsIsAuthorized3()
    {
        setUp::run();

        HeyMan::whenYouSave('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.'\App\User');
    }

    public function testSavingModelsIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouSave('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.saving: '.'\App\User');
    }

    public function testDeletingModelsIsAuthorized1()
    {
        setUp::run();

        HeyMan::whenYouDelete('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.deleting: '.'\App\User');
    }

    public function testDeletingModelsIsAuthorized2()
    {
        setUp::run();

        HeyMan::whenYouDelete(['\App\User'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.deleting: '.'\App\User');
    }

    public function testFetchingModelsIsAuthorized()
    {
        setUp::run();

        HeyMan::whenYouFetch('\App\User')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        event('eloquent.retrieved: '.'\App\User');
    }
}
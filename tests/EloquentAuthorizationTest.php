<?php

use App\User;
use App\User2;
use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EloquentAuthorizationTest extends TestCase
{
    public function testCreatingModelsIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenCreating(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenCreating(User2::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);
    }

    public function testUpdatingModelsIsAuthorized()
    {
        setUp::run($this);
        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);

        HeyMan::whenUpdating(User::class)->youShouldHaveRole('writer')->otherwise()->weDenyAccess();
        HeyMan::whenCreating(User2::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        User::find(2)->update(['name' => 'imdfvn']);
        $this->assertTrue(true);
    }

    public function testUpdatingModelsIsAuthorized2()
    {
        setUp::run($this);
        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);

        HeyMan::whenUpdating(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        $user = User::find(2);
        $user->name = 'sss';
        $user->save();
    }

    public function testُSavingModelsIsAuthorized2()
    {
        setUp::run($this);
        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);

        HeyMan::whenSaving(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        $user = User::find(2);
        $user->name = 'sss';
        $user->save();
    }

    public function testُSavingModelsIsAuthorized3()
    {
        setUp::run($this);
        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);

        HeyMan::whenUpdating(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenSaving(User::class)->youShouldHaveRole('writer')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        User::find(2)->update(['name' => 'sdcsdc']);
    }

    public function testُSavingModelsIsAuthorized1()
    {
        setUp::run($this);
        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);

        HeyMan::whenSaving(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        User::find(2)->update(['name' => 'sdcsdc']);
    }

    public function testُDeletingModelsIsAuthorized1()
    {
        setUp::run($this);
        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);

        HeyMan::whenDeleting(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        User::find(2)->delete();
    }

    public function testُDeletingModelsIsAuthorized2()
    {
        setUp::run($this);
        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);

        HeyMan::whenDeleting([User::class])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        User::destroy([2]);
    }

    public function testFetchingModelsIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenFetching(User::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenCreating(User2::class)->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        User::find(1);
    }
}
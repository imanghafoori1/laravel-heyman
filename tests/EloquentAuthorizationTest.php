<?php

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class EloquentAuthorizationTest extends TestCase
{
    public function testCreatingModelsIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenCreatingModel(User::class)->youShouldHaveRole('reader')->beCareful();

        $this->expectException(AuthorizationException::class);

        User::create(['name' => 'iman', 'email' => 'n@gmail.com', 'password' => bcrypt('a')]);
    }
}
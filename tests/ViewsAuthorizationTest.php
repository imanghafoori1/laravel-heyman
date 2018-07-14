<?php

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Facades\HeyMan;

class ViewsAuthorizationTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenYouSeeViewFile('welcome')->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }

    public function testUrlIsAuthorized2134()
    {
        setUp::run($this);

        HeyMan::whenYouSeeViewFile(['welcome'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();
        HeyMan::whenYouSeeViewFile(['welcome1'])->youShouldHaveRole('reader')->otherwise()->weDenyAccess();

        $this->expectException(AuthorizationException::class);

        view('welcome');
    }
}
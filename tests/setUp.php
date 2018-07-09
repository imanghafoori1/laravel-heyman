<?php

use App\User;
use Imanghafoori\HeyMan\Models\Role;

class setUp
{
    public static function run($testCase)
    {
        $testCase->artisan('migrate', ['--database' => 'testbench']);
        User::create(['name' => 'iman', 'email' => 'iman@gmail.com', 'password' => bcrypt('a')]);
        $user = User::find(1);
        auth()->loginUsingId(1);
        $writerRole = Role::create(['name' => 'writer']);
        $user->assignRole($writerRole);
    }
}
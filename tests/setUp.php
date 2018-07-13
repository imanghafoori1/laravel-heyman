<?php

use App\User;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Models\Role;

class setUp
{
    public static function run($testCase)
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        Route::get('/welcome1', function () {
            return view('welcome');
        })->name('welcome1.name');

        Route::get('/event/{event}', function ($event) {
            event($event);
        })->name('event.name');


        $testCase->artisan('migrate', ['--database' => 'testbench']);
        User::create(['name' => 'iman', 'email' => 'iman@gmail.com', 'password' => bcrypt('a')]);
        $user = User::find(1);
        auth()->loginUsingId(1);
        $writerRole = Role::create(['name' => 'writer']);
        $user->assignRole($writerRole);
    }
}
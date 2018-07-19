<?php

use App\User;
use Illuminate\Support\Facades\Route;

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
        User::create(['name' => 'iman', 'role' => 'writer', 'email' => 'iman@gmail.com', 'password' => bcrypt('a')]);
        auth()->loginUsingId(1);
    }
}
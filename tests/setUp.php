<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class setUp
{
    public static function run()
    {
        self::defineRoutes();
        self::mock();
    }

    public static function defineRoutes()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        Route::get('/welcome1', function () {
            return view('welcome');
        })->name('welcome1.name');

        Route::get('/event/{event}', function ($event) {
            event($event);
        })->name('event.name');


        Route::post('/post', function () {
            return 'aa';
        })->name('post.name');

        Route::patch('patch', function () {
            return 'aa';
        })->name('patch.name');

        Route::patch('/delete', function () {
            return 'aa';
        })->name('delete.name');
    }

    private static function mock()
    {
        Gate::shouldReceive('define')->andReturn(true);
        Gate::shouldReceive('allows')->with('heyman.youShouldHaveRole', ['reader'])->andReturn(false);
        Gate::shouldReceive('allows')->with('heyman.youShouldHaveRole', ['writer'])->andReturn(true);
        Gate::shouldReceive('allows')->with('heyman.youShouldHaveRole', ['writer', 'payload'])->andReturn(true);
        Gate::shouldReceive('allows')->andReturn(false);
        Gate::shouldReceive('define')->andReturn(true);
        Auth::shouldReceive('guest')->andReturn(false);
    }
}

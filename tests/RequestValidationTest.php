<?php

namespace Imanghafoori\HeyManTests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Imanghafoori\HeyMan\Facades\HeyMan;
use Imanghafoori\HeyMan\StartGuarding;
use Imanghafoori\HeyManTests\Stubs\HomeController;
use Imanghafoori\MakeSure\Facades\MakeSure;

class RequestValidationTest extends TestCase
{
    public function testUrlIsNotAccessedWithInValidRequest()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);
        HeyMan::whenYouVisitUrl('welcome')->youShouldBeLoggedIn()->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        $this->get('welcome')->assertStatus(302)->assertSessionHasErrors('name');
    }

    public function testUrlIsAccessedWithValidRequest()
    {
        Route::post('/welcome', HomeController::class.'@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);
        HeyMan::whenYouVisitUrl('welcome')->youShouldBeLoggedIn()->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        $this->post('welcome', ['name' => 'Iman'])->assertStatus(200);
    }

    public function testUrlIsAccessedWithValidRequest2()
    {
        Route::post('/welcome', HomeController::class.'@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')
            ->yourRequestShouldBeValid(['name' => 'required'])
            ->otherwise()
            ->response()->json(['Error' => 'Request Invalid !!!'], 400);

        HeyMan::whenYouVisitUrl('welcome')->youShouldBeLoggedIn()->otherwise()->weDenyAccess();

        app(StartGuarding::class)->start();
        $this->post('welcome', ['name' => 'Iman'])->assertStatus(200);
    }

    public function testUrlIsNotAccessedWithInValidRequest2()
    {
        Route::post('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')
            ->yourRequestShouldBeValid(['name' => 'required'])
            ->otherwise()
            ->redirect()->to('/sss', 301);

        app(StartGuarding::class)->start();

        $this->post('welcome', [])->assertRedirect('/sss')->assertStatus(301);
    }

    public function testUrlIsNotAccessedWithInValidRequestInOrder()
    {
        Route::get('/welcome', HomeController::class.'@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')->youShouldBeLoggedIn()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);

        app(StartGuarding::class)->start();
        $this->get('welcome')->assertStatus(403)->assertSessionMissing('errors');
    }

    public function test_request_is_validated_and_errors_are_set()
    {
        Route::post('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(function () {
            return ['name' => 'required'];
        });

        app(StartGuarding::class)->start();

        MakeSure::about($this)
            ->sendingPostRequest('/welcome', ['f' => 'f'])
            ->isRespondedWith()
            ->statusCode(302)
            ->withError('name');
    }

    public function test_request_is_validated_and_errors_are_set2()
    {
        Route::post('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(
            [HeyManValidationTest::class, 'rules']
        );

        app(StartGuarding::class)->start();

        MakeSure::about($this)
            ->sendingPostRequest('/welcome', ['f' => 'f'])
            ->isRespondedWith()
            ->statusCode(302)
            ->withError('name');
    }

    public function test_multiple_rules_on_single_route()
    {
        Route::post('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(function () {
            return ['name' => 'required'];
        });
        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(function () {
            return ['fname' => 'required'];
        });

        app(StartGuarding::class)->start();
        $this->post('welcome', ['name' => 'required'])->assertStatus(302)
            ->assertSessionHasErrors('fname');

        $errors = session()->get('errors')->getBag('default');
        $this->assertFalse($errors->has('name'));
    }

    public function test_request_data_is_modified_before_validation()
    {
        Route::post('/welcome', HomeController::class.'@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(function () {
            return ['name' => 'required'];
        })->beforeValidationModifyData(function ($requestData) {
            $requestData['name'] = 'John Doe';

            return $requestData;
        });

        app(StartGuarding::class)->start();
        $this->post('welcome', ['f' => 'f'])->assertStatus(200)->assertSessionMissing('errors');
    }
}

class HeyManValidationTest
{
    public static function rules()
    {
        return ['name' => 'required'];
    }
}

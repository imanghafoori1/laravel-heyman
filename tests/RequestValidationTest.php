<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class RequestValidationTest extends TestCase
{
    public function testUrlIsNotAccessedWithInValidRequest()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);
        HeyMan::whenYouVisitUrl('welcome')->youShouldBeLoggedIn()->otherwise()->weDenyAccess();

        $this->get('welcome')->assertStatus(302)->assertSessionHasErrors('name');
    }

    public function testUrlIsNotAccessedWithInValidRequestInOrder()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');
        Auth::shouldReceive('check')->andReturn(false);
        HeyMan::whenYouVisitUrl('welcome')->youShouldBeLoggedIn()->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome')->yourRequestShouldBeValid(['name' => 'required']);

        $this->get('welcome')->assertStatus(403)->assertSessionMissing('errors');
    }

    public function test_request_is_validated_and_errors_are_set()
    {
        Route::post('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(function () {
            return ['name' => 'required'];
        });

        MakeSure::that($this)
            ->sendingPostRequest('/welcome', ['f' => 'f'])
            ->isRespondedWith()
            ->statusCode(302)
            ->withError('name');
    }

    public function test_multiple_rules_on_single_route()
    {
        Route::post('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(function () {
            return ['name' => 'required'];
        });
        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(function () {
            return ['fname' => 'required'];
        });

        $this->post('welcome', ['name' => 'required'])->assertStatus(302)
            ->assertSessionHasErrors('fname');

        $errors = session()->get('errors')->getBag('default');
        $this->assertFalse($errors->has('name'));
    }

    public function test_request_data_is_modified_before_validation()
    {
        Route::post('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouHitRouteName('welcome.name')->yourRequestShouldBeValid(function () {
            return ['name' => 'required'];
        })->beforeValidationModifyData(function ($requestData) {
            $requestData['name'] = 'John Doe';

            return $requestData;
        });

        $this->post('welcome', ['f' => 'f'])->assertStatus(200)->assertSessionMissing('errors');
    }
}

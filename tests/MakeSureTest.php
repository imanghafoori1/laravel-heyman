<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class MakeSureTest extends TestCase
{
    public function test_sendingGetRequest()
    {
        $response = Mockery::mock();
        $response->shouldReceive('assertStatus')->once()->with(403);
        $redirector = Mockery::mock();

        $redirector->shouldReceive('get')->once()->andReturn($response);
        Heyman::makeSure($redirector)->sendingGetRequest('/welcome')->isRespondedWith()->statusCode(403);
    }

    public function test_sendingPostRequest()
    {
        $formData = ['asdc' => 'yuik'];

        $redirector = Mockery::mock();
        $redirector->shouldReceive('post')->with('welcome', $formData)->once();
        Heyman::makeSure($redirector)->sendingPostRequest('welcome', $formData);
    }

    public function test_sendingPutRequest()
    {
        $formData = ['asdc' => 'yuik'];
        $redirector = Mockery::mock();
        $redirector->shouldReceive('put')->with('welcome', $formData)->once();
        Heyman::makeSure($redirector)->sendingPutRequest('welcome', $formData);
    }

    public function test_sendingPatchRequest()
    {
        $formData = ['asdc' => 'yuik'];
        $redirector = Mockery::mock();
        $redirector->shouldReceive('patch')->with('welcome', $formData)->once();
        Heyman::makeSure($redirector)->sendingPatchRequest('welcome', $formData);
    }

    public function test_sendingDeleteRequest()
    {
        $formData = ['asdc' => 'yuik'];
        $redirector = Mockery::mock();
        $redirector->shouldReceive('delete')->with('welcome', $formData)->once();
        Heyman::makeSure($redirector)->sendingDeleteRequest('welcome', $formData);
    }

    public function test_isOk()
    {
        $response = Mockery::mock();
        $response->shouldReceive('assertSuccessful')->once()->with(null);

        $phpunit = Mockery::mock();
        $phpunit->shouldReceive('get')->once()->andReturn($response);
        Heyman::makeSure($phpunit)->sendingGetRequest('/welcome')->isOk();
    }

    public function test_statusCode()
    {
        $chain = Mockery::mock();
        $chain->shouldReceive('addAssertion')->once()->with('assertSuccessful', null);
        $resp = new \Imanghafoori\HeyMan\MakeSure\Expectations\Response($chain);
        $resp->success();
    }

    public function test_forbiddenCode()
    {
        $chain = Mockery::mock();
        $chain->shouldReceive('addAssertion')->once()->with('assertStatus', 403);
        $resp = new \Imanghafoori\HeyMan\MakeSure\Expectations\Response($chain);
        $resp->forbiddenStatus();
    }


    public function test_success()
    {
        $chain = Mockery::mock();
        $chain->shouldReceive('addAssertion')->once()->with('assertSuccessful', null);
        $resp = new \Imanghafoori\HeyMan\MakeSure\Expectations\Response($chain);
        $resp->success();
    }

    public function test_checkPoint()
    {
        $this->expectsEvents('heyman_checkpoint_wow');
        Heyman::checkPoint('wow');

    }

}

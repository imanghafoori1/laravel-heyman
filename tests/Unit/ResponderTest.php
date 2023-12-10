<?php

namespace Imanghafoori\HeyManTests\Unit;

use Facades\Imanghafoori\HeyMan\Core\Chain;
use Illuminate\Support\Str;
use Imanghafoori\HeyMan\Core\Reaction;
use Imanghafoori\HeyMan\Plugins\Reactions\Redirect\RedirectionMsg;
use Imanghafoori\HeyMan\Plugins\Reactions\Redirect\Redirector;
use Imanghafoori\HeyMan\Core\ChainCollection;
use Imanghafoori\HeyManTests\TestCase;
use Mockery;

class ResponderTest extends TestCase
{
    public function testRedirectToIntended()
    {
        $methods = [
            'stream',
            'streamDownload',
            'view',
            'make',
            'json',
            'jsonp',
            'download',
        ];
        $m = \Mockery::mock(ChainCollection::class);
        $m->shouldReceive('commitChain')->times(7);
        app()->instance('heyman.chains', $m);

        foreach ($methods as $method) {
            $param = Str::random(3);

            $reaction = resolve(Reaction::class);
            $reaction->response()->{$method}($param);
        }
    }

    public function testRedirect()
    {
        $methods = [
            'intended',
            'action',
            'route',
            'guest',
            'to',
        ];

        $m = \Mockery::mock(ChainCollection::class);
        $m->shouldReceive('commitChain')->times(5);
        app()->instance('heyman.chains', $m);

        foreach ($methods as $method) {
            $param = Str::random(3);

            $reaction = resolve(Reaction::class);
            $reaction->redirect()->{$method}($param);
        }
    }

    public function testRedirectMsg()
    {
        $methods = [
            'with',
            'withCookies',
            'withInput',
            'onlyInput',
            'exceptInput',
            'withErrors',
            'nonExistentMethod',
        ];

        foreach ($methods as $method) {
            $param = Str::random(2);
            $redirector = Mockery::mock(Redirector::class);
            app(Chain::class)->shouldReceive('push')->once()->with('data', [$method, [[$param]]]);
            $redirectionMsg = new RedirectionMsg($redirector);
            $redirectionMsg->{$method}([$param]);
        }
    }
}

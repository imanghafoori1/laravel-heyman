<?php


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
        foreach ($methods as $method) {
            $param = str_random(3);

            \Facades\Imanghafoori\HeyMan\ChainManager::shouldReceive('submitChainConfig')->once();
            \Facades\Imanghafoori\HeyMan\ChainManager::shouldReceive('set')
                ->once()->with('responseType',  'response');

            \Facades\Imanghafoori\HeyMan\ChainManager::shouldReceive('push')
                ->once()->with('data', [$method, [$param]]);

            $reaction = app(\Imanghafoori\HeyMan\Reactions\Reactions::class);
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

        foreach ($methods as $method) {
            $param = str_random(3);
            \Facades\Imanghafoori\HeyMan\ChainManager::shouldReceive('submitChainConfig')->once();
            \Facades\Imanghafoori\HeyMan\ChainManager::shouldReceive('set')->once()->with('responseType', 'redirect');
            \Facades\Imanghafoori\HeyMan\ChainManager::shouldReceive('push')->once()->with('data', [$method, [$param]]);

            $reaction = app(\Imanghafoori\HeyMan\Reactions\Reactions::class);
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
            $param = str_random(2);
            $Redirector = Mockery::mock(\Imanghafoori\HeyMan\Reactions\Redirect\Redirector::class);
            app(\Facades\Imanghafoori\HeyMan\ChainManager::class)->shouldReceive('push')->once()->with('data', [$method, [[$param]]]);
            $redirectionMsg = new \Imanghafoori\HeyMan\Reactions\Redirect\RedirectionMsg($Redirector);
            $redirectionMsg->{$method}([$param]);
        }
    }
}

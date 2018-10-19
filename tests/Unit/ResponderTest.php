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
            \Facades\Imanghafoori\HeyMan\ChainManager::shouldReceive('commitCalledMethod')->once()->with([$method, [$param]], 'response');
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
            \Facades\Imanghafoori\HeyMan\ChainManager::shouldReceive('commitCalledMethod')->once()->with([$method, [$param]], 'redirect');

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
            app(\Facades\Imanghafoori\HeyMan\ChainManager::class)->shouldReceive('commitCalledMethod')->once()->with([$method, [[$param]]], 'redirect');
            $redirectionMsg = new \Imanghafoori\HeyMan\Reactions\Redirect\RedirectionMsg($Redirector);
            $redirectionMsg->{$method}([$param]);
        }
    }
}

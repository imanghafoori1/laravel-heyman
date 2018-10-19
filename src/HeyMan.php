<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\MakeSure\HttpClient;
use Imanghafoori\HeyMan\Situations\SituationsProxy;
use Imanghafoori\HeyMan\Switching\Turn;

class HeyMan
{
    use Turn;

    public function forget(): Forget
    {
        return new Forget();
    }

    public function __call($method, $args)
    {
        resolve(ChainManager::class)->startChain();

        if (config()->get('app.debug') and !app()->environment('production')) {
            $d = array_only(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1], ['file', 'line', 'args']);
            resolve(ChainManager::class)->set('debugInfo', $d);
        }

        return  SituationsProxy::call($method, $args);
    }

    public function makeSure($app): HttpClient
    {
        return new HttpClient($app);
    }

    public function checkPoint($pointName)
    {
        event('heyman_checkpoint_'.$pointName);
    }
}

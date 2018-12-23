<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Switching\Turn;
use Imanghafoori\HeyMan\MakeSure\HttpClient;
use Imanghafoori\HeyMan\Conditions\ConditionsFacade;
use Imanghafoori\HeyMan\WatchingStrategies\SituationsProxy;

class HeyMan
{
    use Turn;

    public function forget(): Forget
    {
        return new Forget();
    }

    public function __call($method, $args)
    {
        resolve('heyman.chain')->startChain();

        if (config()->get('app.debug') and ! app()->environment('production')) {
            $info = array_only(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1], ['file', 'line', 'args']);
            resolve('heyman.chain')->set('debugInfo', $info);
        }

        return  SituationsProxy::call($method, $args);
    }

    public function makeSure($testCase): HttpClient
    {
        return new HttpClient($testCase);
    }

    public function checkPoint(string $pointName)
    {
        event('heyman_checkpoint_'.$pointName);
    }

    public function condition(string $name, $callable)
    {
        app(ConditionsFacade::class)->define($name, $callable);
    }
}

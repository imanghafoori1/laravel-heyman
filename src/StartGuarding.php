<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\WatchingStrategies\Routes\RouterEventManager;

class StartGuarding
{
    public function start()
    {
        foreach (resolve('AllChains')->data as $manager => $f) {
            if ($manager == RouterEventManager::class) {
                continue;
            }
            foreach ($f as $value => $callbacks) {
                foreach ($callbacks as $key => $cb) {
                    resolve($manager)->register($value, $cb, $key);
                }
            }
        }
    }

}
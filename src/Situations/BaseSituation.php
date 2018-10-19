<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\ChainManager;

abstract class BaseSituation
{
    public function hasMethod($method)
    {
        return false;
    }

    protected function setManager(string $class, ...$array)
    {
        resolve(ChainManager::class)->set('eventManager', resolve($class)->init(...$array));
    }
}

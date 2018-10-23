<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

abstract class BaseSituation
{
    public function hasMethod($method)
    {
        return false;
    }

    protected function setManager(string $class, ...$array)
    {
        resolve('heyman.chain')->set('eventManager', resolve($class)->init(...$array));
    }
}

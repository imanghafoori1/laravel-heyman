<?php

namespace Imanghafoori\HeyMan\Situations;

use Imanghafoori\HeyMan\Chain;

abstract class BaseSituation
{
    public function hasMethod($method)
    {
        return false;
    }

    protected function setManager(string $class, ...$array)
    {
        resolve(Chain::class)->eventManager = resolve($class)->init(...$array);
    }
}

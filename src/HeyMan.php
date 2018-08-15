<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\EventHooks;
use Imanghafoori\HeyMan\Hooks\RouteHooks;
use Imanghafoori\HeyMan\Hooks\ViewHooks;
use Imanghafoori\HeyMan\Normilizers\InputNormalizer;

class HeyMan
{
    use EloquentHooks, RouteHooks, ViewHooks, EventHooks, InputNormalizer;

    private $chain;

    /**
     * HeyMan constructor.
     *
     * @param Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    public function turnOff(): Consider
    {
        return new Consider('turnOff');
    }

    public function turnOn(): Consider
    {
        return new Consider('turnOn');
    }

    public function forget(): Forget
    {
        return new Forget();
    }
}

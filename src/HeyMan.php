<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\EventHooks;
use Imanghafoori\HeyMan\Hooks\RouteHooks;
use Imanghafoori\HeyMan\Hooks\ViewHooks;

class HeyMan
{
    use EloquentHooks, RouteHooks, ViewHooks, EventHooks;

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

    /**
     * @param $url
     *
     * @return array
     */
    private function normalizeInput(array $url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }

    public function turnOff(): Consider
    {
        return new Consider('turnOff');
    }

    public function turnOn(): Consider
    {
        return new Consider('turnOn');
    }
}

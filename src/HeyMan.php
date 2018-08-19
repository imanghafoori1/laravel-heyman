<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\EventHooks;
use Imanghafoori\HeyMan\Hooks\ViewHooks;
use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\Situations\RouteSituations;
use Imanghafoori\HeyMan\Situations\ViewSituations;

class HeyMan
{
    use EloquentHooks, ViewHooks, EventHooks, InputNormalizer;

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

    public function __call($method, $args)
    {
        if (str_contains($method, ['Send', 'Url', 'Route', 'Action'])) {
            return app(RouteSituations::class)->$method(...$args);
        } elseif (str_contains($method, ['View'])) {
            return app(ViewSituations::class)->$method(...$args);
        }
    }
}

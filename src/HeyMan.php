<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\EventHooks;
use Imanghafoori\HeyMan\Normilizers\InputNormalizer;
use Imanghafoori\HeyMan\Situations\RouteSituations;
use Imanghafoori\HeyMan\Situations\ViewSituations;

class HeyMan
{
    use EloquentHooks, EventHooks, InputNormalizer;

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
        foreach ($this->mapping() as $className => $methods) {
            if (str_contains($method, $methods)) {
                return app($className)->$method(...$args);
            }
        }
    }

    /**
     * @return array
     */
    private function mapping(): array
    {
        return [
            RouteSituations::class => ['Send', 'Url', 'Route', 'Action'],
            ViewSituations::class  => ['View'],
        ];
    }
}

<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Situations\EloquentSituations;
use Imanghafoori\HeyMan\Situations\EventSituations;
use Imanghafoori\HeyMan\Situations\RouteSituations;
use Imanghafoori\HeyMan\Situations\ViewSituations;

class HeyMan
{
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
        $this->writeDebugInfo(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2));

        return $this->startChain($method, $args);
    }

    /**
     * @return array
     */
    private function situations(): array
    {
        return [
            RouteSituations::class,
            ViewSituations::class,
            EloquentSituations::class,
            EventSituations::class,
        ];
    }

    /**
     * @param $d
     */
    private function writeDebugInfo($d)
    {
        app(Chain::class)->debugInfo = array_only($d[1], ['file', 'line', 'args']);
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    private function startChain($method, $args)
    {
        foreach ($this->situations() as $className) {
            if (method_exists($className, $method)) {
                return app($className)->$method(...$args);
            }
        }
    }
}

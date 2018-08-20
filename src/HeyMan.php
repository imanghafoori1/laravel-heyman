<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Situations\{EloquentSituations, EventSituations, RouteSituations, ViewSituations};

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
            RouteSituations::class     => ['Send', 'Url', 'Route', 'Action'],
            ViewSituations::class      => ['View'],
            EloquentSituations::class  => ['Fetch', 'Create', 'Update', 'Save', 'Delete'],
            EventSituations::class     => ['Event'],
        ];
    }
}

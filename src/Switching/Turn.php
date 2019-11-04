<?php

namespace Imanghafoori\HeyMan\Switching;

trait Turn
{
    public function turnOff()
    {
        return new Consider('turnOff');
    }

    public function turnOn()
    {
        return new Consider('turnOn');
    }
}

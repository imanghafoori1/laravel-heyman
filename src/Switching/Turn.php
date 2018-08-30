<?php

namespace Imanghafoori\HeyMan\Switching;

trait Turn
{
    public function turnOff(): Consider
    {
        return new Consider('turnOff');
    }

    public function turnOn(): Consider
    {
        return new Consider('turnOn');
    }
}

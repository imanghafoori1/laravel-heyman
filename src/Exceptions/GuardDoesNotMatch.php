<?php

namespace Imanghafoori\HeyMan\Exceptions;

use InvalidArgumentException;
use Illuminate\Support\Collection;

class GuardDoesNotMatch extends InvalidArgumentException
{
    public static function create(string $givenGuard, Collection $expectedGuards)
    {
        return new static("The given role should use guard `{$expectedGuards->implode(', ')}` instead of `{$givenGuard}`.");
    }
}

<?php

namespace Imanghafoori\HeyMan\Plugins\Reactions;

use Imanghafoori\HeyMan\Core\BaseReaction;
use Imanghafoori\HeyMan\Reactions\Then;

class Abort extends BaseReaction
{
    public function abort($code, string $message = null, array $headers = [])
    {
        $this->commit(func_get_args(), [static::class, 'abortIt']);

        return new Then($this);
    }

    public static function abortIt($args)
    {
        return function () use ($args) {
            app()->abort(...$args);
        };
    }
}

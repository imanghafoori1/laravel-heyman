<?php

namespace Imanghafoori\HeyMan\Plugins\Reactions;

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Core\BaseReaction;
use Imanghafoori\HeyMan\Reactions\Then;

class WeThrowException extends BaseReaction
{
    public function weThrowNew(string $exception, string $message = null)
    {
        $this->commit(func_get_args(), [static::class, 'exception']);

        return new Then($this);
    }

    public function weDenyAccess(string $message = null)
    {
        $this->commit([AuthorizationException::class, $message], [static::class, 'exception']);

        return new Then($this);
    }

    public static function exception(array $e)
    {
        return function () use ($e) {
            $exClass = $e[0];
            $message = $e[1];

            throw new $exClass($message);
        };
    }
}

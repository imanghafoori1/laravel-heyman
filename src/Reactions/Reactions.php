<?php

namespace Imanghafoori\HeyMan\Reactions;

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Chain;

final class Reactions
{
    public function response(): Responder
    {
        return new Responder($this);
    }

    public function redirect(): Redirector
    {
        return new Redirector($this);
    }

    public function afterCalling($callback, array $parameters = []): self
    {
        resolve(Chain::class)->addAfterCall($callback, $parameters);

        return $this;
    }

    public function weThrowNew(string $exception, string $message = '')
    {
        resolve(Chain::class)->commit(func_get_args(), 'exception');
    }

    public function abort($code, string $message = '', array $headers = [])
    {
        resolve(Chain::class)->commit(func_get_args(), __FUNCTION__);
    }

    public function weRespondFrom($callback, array $parameters = [])
    {
        resolve(Chain::class)->commit(func_get_args(), 'respondFrom');
    }

    public function weDenyAccess(string $message = '')
    {
        resolve(Chain::class)->commit([AuthorizationException::class, $message], 'exception');
    }

    public function afterFiringEvent($event, $payload = [], $halt = false): self
    {
        resolve(Chain::class)->eventFire($event, $payload, $halt);

        return $this;
    }

    public function __destruct()
    {
        resolve(Chain::class)->submitChainConfig();
    }
}

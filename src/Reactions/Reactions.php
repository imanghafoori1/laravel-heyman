<?php

namespace Imanghafoori\HeyMan\Reactions;

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Chain;

class Reactions
{
    /**
     * @var \Imanghafoori\HeyMan\Chain
     */
    private $chain;

    /**
     * Actions constructor.
     *
     * @param \Imanghafoori\HeyMan\Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    public function response(): Responder
    {
        return new Responder($this->chain, $this);
    }

    public function redirect(): Redirector
    {
        return new Redirector($this->chain, $this);
    }

    public function afterCalling($callback, array $parameters = []): self
    {
        $this->chain->addAfterCall($callback, $parameters);

        return $this;
    }

    public function weThrowNew(string $exception, string $message = '')
    {
        $this->chain->commit(func_get_args(), 'exception');
    }

    public function abort($code, string $message = '', array $headers = [])
    {
        $this->chain->commit(func_get_args(), __FUNCTION__);
    }

    public function weRespondFrom($callback, array $parameters = [])
    {
        $this->chain->commit(func_get_args(), 'respondFrom');
    }

    public function weDenyAccess(string $message = '')
    {
        $this->chain->commit([AuthorizationException::class, $message], 'exception');
    }

    public function afterFiringEvent($event, $payload = [], $halt = false): self
    {
        $this->chain->eventFire($event, $payload, $halt);

        return $this;
    }

    public function __destruct()
    {
        resolve(Chain::class)->submitChainConfig();
    }
}

<?php

namespace Imanghafoori\HeyMan\Reactions;

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Chain;
use Imanghafoori\HeyMan\Reactions\Redirect\Redirector;

final class Reactions
{
    use BeforeReaction;

    public function response(): Responder
    {
        return new Responder($this);
    }

    public function redirect(): Redirector
    {
        return new Redirector($this);
    }

    public function weThrowNew(string $exception, string $message = '')
    {
        $this->commit(func_get_args(), 'exception');
    }

    public function abort($code, string $message = '', array $headers = [])
    {
        $this->commit(func_get_args(), __FUNCTION__);
    }

    public function weRespondFrom($callback, array $parameters = [])
    {
        $this->commit(func_get_args(), 'respondFrom');
    }

    public function weDenyAccess(string $message = '')
    {
        $this->commit([AuthorizationException::class, $message], 'exception');
    }

    public function __destruct()
    {
        resolve(Chain::class)->submitChainConfig();
    }

    private function commit($args, $methodName)
    {
        resolve(Chain::class)->commitCalledMethod($args, $methodName);
    }
}

<?php

namespace Imanghafoori\HeyMan\Reactions;

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\ChainManager;
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

        return new Then($this);
    }

    public function abort($code, string $message = '', array $headers = [])
    {
        $this->commit(func_get_args(), __FUNCTION__);

        return new Then($this);
    }

    public function weRespondFrom($callback, array $parameters = [])
    {
        $this->commit(func_get_args(), 'respondFrom');

        return new Then($this);
    }

    public function weDenyAccess(string $message = '')
    {
        $this->commit([AuthorizationException::class, $message], 'exception');

        return new Then($this);
    }

    public function __destruct()
    {
        resolve(ChainManager::class)->submitChainConfig();
    }

    private function commit($args, $methodName)
    {
        resolve(ChainManager::class)->commitCalledMethod($args, $methodName);
    }
}

<?php

namespace Imanghafoori\HeyMan\Reactions;

use Illuminate\Auth\Access\AuthorizationException;
use Imanghafoori\HeyMan\Reactions\Redirect\Redirector;

final class Reactions
{
    use BeforeReaction;

    public function response(): Responder
    {
        resolve('heyman.chain')->set('responseType', 'response');

        return new Responder($this);
    }

    public function redirect(): Redirector
    {
        resolve('heyman.chain')->set('responseType', 'redirect');

        return new Redirector($this);
    }

    public function weThrowNew(string $exception, string $message = null)
    {
        $this->commit(func_get_args(), 'exception');

        return new Then($this);
    }

    public function abort($code, string $message = null, array $headers = [])
    {
        $this->commit(func_get_args(), __FUNCTION__);

        return new Then($this);
    }

    public function weRespondFrom($callback, array $parameters = [])
    {
        $this->commit(func_get_args(), 'respondFrom');

        return new Then($this);
    }

    public function weDenyAccess(string $message = null)
    {
        $this->commit([AuthorizationException::class, $message], 'exception');

        return new Then($this);
    }

    public function __destruct()
    {
        resolve('heyman.chains')->commitChain();
    }

    private function commit($args, $methodName)
    {
        $chain = resolve('heyman.chain');
        $chain->push('data', $args);
        $chain->set('responseType', $methodName);
    }
}

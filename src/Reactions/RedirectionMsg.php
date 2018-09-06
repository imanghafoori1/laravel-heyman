<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

/**
 * Class RedirectionMsg.
 *
 * @method with($key, $value = null)
 * @method withCookies(array $cookies)
 * @method withInput(array $input = null)
 * @method onlyInput()
 * @method exceptInput(): self
 * @method withErrors($provider, $key = 'default')
 */
final class RedirectionMsg
{
    private $redirect;

    /**
     * Redirector constructor.
     *
     * @param Redirector $redirect
     */
    public function __construct(Redirector $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return $this
     */
    public function __call($method, $parameters)
    {
        resolve(Chain::class)->commitCalledMethod([$method, $parameters], 'redirect');

        return $this;
    }
}

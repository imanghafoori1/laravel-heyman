<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

/**
 * Class RedirectionMsg
 *
 * @method with($key, $value = null)
 * @method withCookies(array $cookies)
 * @method withInput(array $input = null)
 * @method onlyInput()
 * @method exceptInput(): self
 * @method withErrors($provider, $key = 'default')
 *
 * @package Imanghafoori\HeyMan\Reactions
 */
class RedirectionMsg
{
    private $chain;

    private $redirect;

    /**
     * Redirector constructor.
     *
     * @param Chain      $chain
     * @param Redirector $redirect
     */
    public function __construct(Chain $chain, Redirector $redirect)
    {
        $this->chain = $chain;
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
        $this->chain->commitArray([$method, $parameters], 'redirect');

        return $this;
    }
}

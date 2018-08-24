<?php

namespace Imanghafoori\HeyMan\Reactions;

use Imanghafoori\HeyMan\Chain;

class Redirector
{
    private $chain;

    private $action;

    /**
     * Responder constructor.
     *
     * @param Chain     $chain
     * @param Reactions $reaction
     */
    public function __construct(Chain $chain, Reactions $reaction)
    {
        $this->chain = $chain;
        $this->action = $reaction;
    }

    /**
     * Create a new redirect response to the given path.
     *
     * @param string    $path
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     *
     * @return RedirectionMsg
     */
    public function to(string $path, int $status = 302, array $headers = [], $secure = null): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return $this->redirectMsgObj();
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param string $route
     * @param array  $parameters
     * @param int    $status
     * @param array  $headers
     *
     * @return RedirectionMsg
     */
    public function route(string $route, array $parameters = [], int $status = 302, array $headers = []): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return $this->redirectMsgObj();
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param string $action
     * @param array  $parameters
     * @param int    $status
     * @param array  $headers
     *
     * @return RedirectionMsg
     */
    public function action($action, array $parameters = [], int $status = 302, array $headers = []): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return $this->redirectMsgObj();
    }

    /**
     * Create a new redirect response, while putting the current URL in the session.
     *
     * @param string    $path
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     *
     * @return RedirectionMsg
     */
    public function guest($path, int $status = 302, array $headers = [], $secure = null): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return $this->redirectMsgObj();
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param string    $default
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     *
     * @return RedirectionMsg
     */
    public function intended(string $default = '/', int $status = 302, array $headers = [], $secure = null): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return $this->redirectMsgObj();
    }

    /**
     * @return RedirectionMsg
     */
    private function redirectMsgObj(): RedirectionMsg
    {
        return new RedirectionMsg($this->chain, $this);
    }
}

<?php

namespace Imanghafoori\HeyMan;

class Redirector
{
    private $chain;

    private $action;

    /**
     * Responder constructor.
     *
     * @param \Imanghafoori\HeyMan\Chain $chain
     * @param $action
     */
    public function __construct(Chain $chain, $action)
    {
        $this->chain = $chain;
        $this->action = $action;
    }

    /**
     * Create a new redirect response to the given path.
     *
     * @param string    $path
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     */
    public function to($path, $status = 302, $headers = [], $secure = null): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());
        return new RedirectionMsg($this->chain, $this);
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param string $route
     * @param array  $parameters
     * @param int    $status
     * @param array  $headers
     */
    public function route($route, $parameters = [], $status = 302, $headers = []): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return new RedirectionMsg($this->chain, $this);
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param string $action
     * @param array  $parameters
     * @param int    $status
     * @param array  $headers
     */
    public function action($action, $parameters = [], $status = 302, $headers = []): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return new RedirectionMsg($this->chain, $this);
    }

    /**
     * Create a new redirect response, while putting the current URL in the session.
     *
     * @param string    $path
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     */
    public function guest($path, $status = 302, $headers = [], $secure = null): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return new RedirectionMsg($this->chain, $this);
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param string    $default
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     */
    public function intended($default = '/', $status = 302, $headers = [], $secure = null): RedirectionMsg
    {
        $this->chain->addRedirect(__FUNCTION__, func_get_args());

        return new RedirectionMsg($this->chain, $this);
    }
}

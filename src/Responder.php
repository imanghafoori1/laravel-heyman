<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;

class Responder
{
    private $response;

    private $exception;

    /**
     * Create a new redirect response to the given path.
     *
     * @param string    $path
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     */
    public function redirectTo($path, $status = 302, $headers = [], $secure = null)
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Return a new response from the application.
     *
     * @param string $content
     * @param int    $status
     * @param array  $headers
     */
    public function make($content = '', $status = 200, array $headers = [])
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Return a new view response from the application.
     *
     * @param string $view
     * @param array  $data
     * @param int    $status
     * @param array  $headers
     */
    public function view($view, $data = [], $status = 200, array $headers = [])
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param string|array $data
     * @param int          $status
     * @param array        $headers
     * @param int          $options
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Return a new JSONP response from the application.
     *
     * @param string       $callback
     * @param string|array $data
     * @param int          $status
     * @param array        $headers
     * @param int          $options
     */
    public function jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Return a new streamed response from the application.
     *
     * @param \Closure $callback
     * @param int      $status
     * @param array    $headers
     */
    public function stream($callback, $status = 200, array $headers = [])
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Return a new streamed response as a file download from the application.
     *
     * @param \Closure    $callback
     * @param string|null $name
     * @param array       $headers
     * @param string|null $disposition
     */
    public function streamDownload($callback, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Create a new file download response.
     *
     * @param \SplFileInfo|string $file
     * @param string|null         $name
     * @param array               $headers
     * @param string|null         $disposition
     */
    public function download($file, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param string $route
     * @param array  $parameters
     * @param int    $status
     * @param array  $headers
     */
    public function redirectToRoute($route, $parameters = [], $status = 302, $headers = [])
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param string $action
     * @param array  $parameters
     * @param int    $status
     * @param array  $headers
     */
    public function redirectToAction($action, $parameters = [], $status = 302, $headers = [])
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Create a new redirect response, while putting the current URL in the session.
     *
     * @param string    $path
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     */
    public function redirectGuest($path, $status = 302, $headers = [], $secure = null)
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param string    $default
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     */
    public function redirectToIntended($default = '/', $status = 302, $headers = [], $secure = null)
    {
        $this->response = [__FUNCTION__, func_get_args()];
    }

    public function weThrowNew($exception, $message = '')
    {
        $this->exception = new $exception($message);
    }

    public function abort($code, $message = '', array $headers = [])
    {
        try {
            abort($code, $message, $headers);
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    public function weDenyAccess($msg = '')
    {
        $this->exception = new AuthorizationException($msg);
    }

    public function afterCalling($callback, array $parameters = [])
    {
        app()->call($callback, $parameters);

        return $this;
    }

    public function __destruct()
    {
        app(HeyMan::class)->startListening($this->response, $this->exception);
    }

    public function afterFiringEvent(...$args)
    {
        app('events')->dispatch(...$args);

        return $this;
    }
}

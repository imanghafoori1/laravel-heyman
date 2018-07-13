<?php

namespace Imanghafoori\HeyMan;

use Symfony\Component\HttpFoundation\Response;

class Responder
{
    private $response;

    private $exception;

    /**
     * Create a new redirect response to the given path.
     *
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     */
    public function redirectTo($path, $status = 302, $headers = [], $secure = null)
    {
        $this->response = response()->redirectTo($path, $status, $headers, $secure);
    }


    /**
     * Return a new response from the application.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     */
    public function make($content = '', $status = 200, array $headers = [])
    {
        $this->response = response()->make($content, $status, $headers);
    }

    /**
     * Return a new view response from the application.
     *
     * @param  string  $view
     * @param  array  $data
     * @param  int  $status
     * @param  array  $headers
     */
    public function view($view, $data = [], $status = 200, array $headers = [])
    {
        $this->response = response()->view($view, $data, $status, $headers );
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array  $data
     * @param  int  $status
     * @param  array  $headers
     * @param  int  $options
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        $this->response = response()->json($data, $status, $headers, $options);
    }
    /**
     * Return a new JSONP response from the application.
     *
     * @param  string  $callback
     * @param  string|array  $data
     * @param  int  $status
     * @param  array  $headers
     * @param  int  $options
     */
    public function jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        $this->response = response()->jsonp($callback, $data, $status, $headers, $options);
    }

    /**
     * Return a new streamed response from the application.
     *
     * @param  \Closure  $callback
     * @param  int  $status
     * @param  array  $headers
     */
    public function stream($callback, $status = 200, array $headers = [])
    {
        $this->response = response()->stream($callback, $status, $headers);
    }

    /**
     * Return a new streamed response as a file download from the application.
     *
     * @param  \Closure  $callback
     * @param  string|null  $name
     * @param  array  $headers
     * @param  string|null  $disposition
     */
    public function streamDownload($callback, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $this->response = response()->streamDownload($callback, $name, $headers, $disposition );
    }

    /**
     * Create a new file download response.
     *
     * @param  \SplFileInfo|string  $file
     * @param  string|null  $name
     * @param  array  $headers
     * @param  string|null  $disposition
     */
    public function download($file, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $this->response = response()->download($file, $name, $headers, $disposition );
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param  string  $route
     * @param  array  $parameters
     * @param  int  $status
     * @param  array  $headers
     */
    public function redirectToRoute($route, $parameters = [], $status = 302, $headers = [])
    {
        $this->response = response()->redirectToRoute($route, $parameters, $status, $headers);
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param  string  $action
     * @param  array  $parameters
     * @param  int  $status
     * @param  array  $headers
     */
    public function redirectToAction($action, $parameters = [], $status = 302, $headers = [])
    {
        $this->response = response()->redirectToAction($action, $parameters, $status, $headers );
    }

    /**
     * Create a new redirect response, while putting the current URL in the session.
     *
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     */
    public function redirectGuest($path, $status = 302, $headers = [], $secure = null)
    {
        $this->response = response()->redirectGuest($path, $status, $headers, $secure);
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param  string  $default
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     */
    public function redirectToIntended($default = '/', $status = 302, $headers = [], $secure = null)
    {
        $this->response = response()->redirectToIntended($default, $status, $headers, $secure );
    }

    public function send(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Closure
     */
    private function makeListener(): \Closure
    {
        $resp = $this->response;
        $cb = app(YouShouldHave::class)->predicate;

        if ($this->exception) {
            $e = $this->exception;
            return function () use ($e, $cb) {
                if (!$cb()) {
                    throw $e;
                }
            };
        }

        return function () use ($resp, $cb) {
            if (!$cb()) {
                respondWith($resp);
            }
        };
    }

    public function throwNew($exception, $message= '')
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

    public function __destruct()
    {
        $callbackListener = $this->makeListener();
        app('hey_man')->authorizer->startGuarding($callbackListener);
    }
}
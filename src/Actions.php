<?php

namespace Imanghafoori\HeyMan;

use Illuminate\Auth\Access\AuthorizationException;

class Actions
{
    public $response = [];

    public $redirect = [];

    public $exception = [];

    public function response()
    {
        return new Responder($this);
    }

    public function redirect()
    {
        return new Redirector($this);
    }

    public function afterCalling($callback, array $parameters = [])
    {
        app()->call($callback, $parameters);

        return $this;
    }

    public function weThrowNew($exception, $message = '')
    {
        $this->exception = ['class' => $exception, 'message' => $message];
    }

    public function abort($code, $message = '', array $headers = [])
    {
        try {
            abort($code, $message, $headers);
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    public function weDenyAccess($message = '')
    {
        $this->exception = ['class' => AuthorizationException::class, 'message' => $message];
    }

    public function afterFiringEvent(...$args)
    {
        app('events')->dispatch(...$args);

        return $this;
    }

    public function __destruct()
    {
        app(HeyMan::class)->startListening($this->response, $this->exception, $this->redirect);
    }
}

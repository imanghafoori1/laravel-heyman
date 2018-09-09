<?php

namespace Imanghafoori\HeyMan\MakeSure;

class HttpClient
{
    public $http = [];

    public $assertion;

    public $app;

    public $event;

    public $exception;

    /**
     * HttpClient constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function sendingPostRequest($uri, array $data = [], array $headers = []): IsRespondedWith
    {
        $this->http = [
            'method' => 'post',
            'url' => $uri,
            'data' => $data,
            'headers' => $headers
        ];

        return new IsRespondedWith($this);
    }

    public function sendingDeleteRequest($uri, array $data = [], array $headers = [])
    {
        $this->http = [
            'method' => 'delete',
            'url' => $uri,
            'data'   => $data,
            'headers' => $headers
        ];

        return new IsRespondedWith($this);
    }

    public function sendingPutRequest($uri, array $data = [], array $headers = [])
    {
        $this->http = [
            'method' => 'put',
            'url' => $uri,
            'data' => $data,
            'headers' => $headers
        ];

        return new IsRespondedWith($this);
    }

    public function sendingPatchRequest($uri, array $data = [], array $headers = [])
    {
        $this->http = [
            'method' => 'patch',
            'url' => $uri,
            'data' => $data,
            'headers' => $headers
        ];

        return new IsRespondedWith($this);
    }

    public function sendingGetRequest($url): IsRespondedWith
    {
        $this->http = [
            'method' => 'get',
            'url'    => $url,
            'data'   => [],
        ];

        return new IsRespondedWith($this);
    }

    public function exceptionIsThrown($type)
    {
        $this->exception = $type;
    }

    public function whenEventHappens($event)
    {
        $this->event = $event;

        return $this;
    }

    public function __destruct()
    {
        (new CheckExpectations($this))->check();
    }
}

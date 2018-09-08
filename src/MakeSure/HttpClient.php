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

    public function sendingPostRequest($url, $data = []): IsRespondedWith
    {
        $this->http = [
            'method' => 'post',
            'url' => $url,
            'data' => $data
        ];

        return new IsRespondedWith($this);
    }

    public function sendingGetRequest($url): IsRespondedWith
    {
        $this->http = [
            'method' => 'get',
            'url' => $url,
            'data' => [],
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
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
        $this->http($uri, $data, $headers, 'post');

        return new IsRespondedWith($this);
    }

    public function sendingDeleteRequest($uri, array $data = [], array $headers = [])
    {
        $this->http($uri, $data, $headers, 'delete');

        return new IsRespondedWith($this);
    }

    public function sendingPutRequest($uri, array $data = [], array $headers = [])
    {
        $this->http($uri, $data, $headers, 'put');

        return new IsRespondedWith($this);
    }

    public function sendingPatchRequest($uri, array $data = [], array $headers = [])
    {
        $this->http($uri, $data, $headers, 'patch');

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

    public function whenYouReachCheckPoint($name)
    {
        return $this->whenEventHappens('heyman_checkpoint_'.$name);
    }

    public function __destruct()
    {
        (new CheckExpectations($this))->check();
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @param $str
     */
    private function http($uri, array $data, array $headers, $str)
    {
        $this->http = [
            'method' => $str,
            'url' => $uri,
            'data' => $data,
            'headers' => $headers,
        ];
    }
}

<?php

namespace Imanghafoori\HeyMan\MakeSure;

class HttpClient
{
    public $app;

    private $chain;

    /**
     * HttpClient constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->chain = new Chain($app);
        $this->app = $app;
    }

    public function sendingPostRequest($uri, array $data = [], array $headers = []): IsRespondedWith
    {
        $this->chain->http($uri, $data, $headers, 'post');

        return new IsRespondedWith($this->chain);
    }

    public function sendingDeleteRequest($uri, array $data = [], array $headers = [])
    {
        $this->chain->http($uri, $data, $headers, 'delete');

        return new IsRespondedWith($this->chain);
    }

    public function sendingPutRequest($uri, array $data = [], array $headers = [])
    {
        $this->chain->http($uri, $data, $headers, 'put');

        return new IsRespondedWith($this->chain);
    }

    public function sendingPatchRequest($uri, array $data = [], array $headers = [])
    {
        $this->chain->http($uri, $data, $headers, 'patch');

        return new IsRespondedWith($this->chain);
    }

    public function sendingGetRequest($url): IsRespondedWith
    {
        $this->chain->http = [
            'method' => 'get',
            'url'    => $url,
            'data'   => [],
        ];

        return new IsRespondedWith($this->chain);
    }

    public function exceptionIsThrown($type)
    {
        $this->chain->exception = $type;
    }

    public function whenEventHappens($event)
    {
        $this->chain->event = $event;

        return $this;
    }
}

<?php

namespace Imanghafoori\HeyMan\MakeSure;

class Chain
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public $http = [];

    public $assertion;

    public $event;

    public $exception;


    public function __destruct()
    {
        (new CheckExpectations($this, $this->app))->check();
    }


    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @param $str
     */
    public function http($uri, array $data, array $headers, $str)
    {
        $this->http = [
            'method'  => $str,
            'url'     => $uri,
            'data'    => $data,
            'headers' => $headers,
        ];
    }
}
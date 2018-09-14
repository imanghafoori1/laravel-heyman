<?php

namespace Imanghafoori\HeyMan\MakeSure;

class Chain
{
    private $phpunit;

    public function __construct($phpunit)
    {
        $this->phpunit = $phpunit;
    }

    public $http = [];

    public $assertion = [];

    public $event;

    public $exception;

    public function __destruct()
    {
        (new CheckExpectations($this, $this->phpunit))->check();
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @param $httpVerb
     */
    public function http($uri, array $data, array $headers, $httpVerb)
    {
        $this->http = [
            'method'  => $httpVerb,
            'url'     => $uri,
            'data'    => $data,
            'headers' => $headers,
        ];
    }

    /**
     * @param $url
     * @param $str
     */
    public function addAssertion($str, $url = null)
    {
        $this->assertion[] = ['type' => $str, 'value' => $url];
    }
}

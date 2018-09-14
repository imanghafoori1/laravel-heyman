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
     * @param $method
     */
    public function http($uri, array $data, array $headers, $method)
    {
        $this->http = get_defined_vars();
    }

    /**
     * @param $value
     * @param $type
     */
    public function addAssertion($type, $value = null)
    {
        $this->assertion[] = get_defined_vars();
    }
}

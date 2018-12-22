<?php

namespace Imanghafoori\HeyMan\MakeSure;

class Chain
{
    private $phpunit;

    public function __construct($phpunit)
    {
        $this->phpunit = $phpunit;
    }

    public $data = [];

    public function __destruct()
    {
        (new CheckExpectations($this, $this->phpunit))->check();
    }

    public function http($method, ...$rest)
    {
        $this->data['http'] = get_defined_vars();
    }

    /**
     * @param $value
     * @param $type
     */
    public function addAssertion($type, $value = null)
    {
        $this->data['assertion'][] = get_defined_vars();
    }
}

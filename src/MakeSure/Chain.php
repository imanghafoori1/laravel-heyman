<?php

namespace Imanghafoori\HeyMan\MakeSure;

class Chain
{
    public $data = [];

    private $phpunit;

    public function __construct($phpunit)
    {
        $this->phpunit = $phpunit;
    }

    public function __destruct()
    {
        (new CheckExpectations($this, $this->phpunit))->check();
    }
}

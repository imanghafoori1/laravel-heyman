<?php

namespace Imanghafoori\HeyMan\MakeSure;

class CheckExpectations
{
    private $chain;

    private $phpunit;

    /**
     * CheckExpectations constructor.
     *
     * @param $chain
     * @param $phpunit
     */
    public function __construct(Chain $chain, $phpunit)
    {
        $this->chain = $chain;
        $this->phpunit = $phpunit;
    }

    public function check()
    {
        $this->expectExceptions();
        $this->fireEvents();
        $this->checkResponse();
    }

    private function checkResponse()
    {
        if (isset($this->chain->data['http'])) {
            $response = $this->sendRequest(...$this->chain->data['http']);
            $this->checkResponses($response);
        }
    }

    /**
     * @param $method
     * @param $data
     *
     * @return mixed
     */
    private function sendRequest($method, $data)
    {
        return $this->phpunit->$method(...$data);
    }

    /**
     * @param $response
     */
    private function checkResponses($response)
    {
        foreach ($this->chain->data['assertion'] ?? [] as [$type, $value]) {
            $response->$type($value);
        }
    }

    private function fireEvents()
    {
        if (isset($this->chain->data['event'])) {
            event($this->chain->data['event']);
        }
    }

    private function expectExceptions()
    {
        if (isset($this->chain->data['exception'])) {
            $this->phpunit->expectException($this->chain->data['exception']);
        }
    }
}

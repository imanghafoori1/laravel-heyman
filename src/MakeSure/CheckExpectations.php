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
        if (!$this->chain->http) {
            return;
        }
        $this->checkResponses($this->sendRequest());
    }

    /**
     * @return mixed
     */
    private function sendRequest()
    {
        $method = $this->chain->http['method'];

        $response = $this->phpunit->$method($this->chain->http['url'], $this->chain->http['data']);

        return $response;
    }

    /**
     * @param $response
     */
    private function checkResponses($response)
    {
        foreach ($this->chain->assertion as $assertion) {
            $type = $assertion['type'];
            $response->$type($assertion['value']);
        }
    }

    private function fireEvents()
    {
        if ($this->chain->event) {
            event($this->chain->event);
        }
    }

    private function expectExceptions()
    {
        if ($this->chain->exception) {
            $this->phpunit->expectException($this->chain->exception);
        }
    }
}

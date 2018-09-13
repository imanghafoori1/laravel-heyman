<?php

namespace Imanghafoori\HeyMan\MakeSure;

class CheckExpectations
{
    private $last;

    private $test;

    /**
     * CheckExpectations constructor.
     *
     * @param $last
     * @param $test
     */
    public function __construct($last, $test)
    {
        $this->last = $last;
        $this->test = $test;
    }

    public function check()
    {
        $this->expectExceptions();
        $this->fireEvents();
        $this->checkResponse();
    }

    private function checkResponse()
    {
        if (!$this->last->http) {
            return;
        }
        $this->checkResponses($this->sendRequest());
    }

    /**
     * @return mixed
     */
    private function sendRequest()
    {
        $method = $this->last->http['method'];

        $response = $this->test->$method($this->last->http['url'], $this->last->http['data']);

        return $response;
    }

    /**
     * @param $response
     */
    private function checkResponses($response)
    {
        foreach ($this->last->assertion as $assertion) {
            $type = $assertion['type'];
            $response->$type($assertion['value']);
        }
    }

    private function fireEvents()
    {
        if ($this->last->event) {
            event($this->last->event);
        }
    }

    private function expectExceptions()
    {
        if ($this->last->exception) {
            $this->test->expectException($this->last->exception);
        }
    }
}

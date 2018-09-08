<?php

namespace Imanghafoori\HeyMan\MakeSure;

class CheckExpectations
{
    private $last;

    /**
     * CheckExpectations constructor.
     *
     * @param $last
     */
    public function __construct($last)
    {
        $this->last = $last;
    }

    public function check()
    {
        $this->checkExceptions();
        $this->fireEvents();
        $this->checkResponse();
    }

    private function checkResponse()
    {
        if (!$this->last->http) {
            return;
        }
        $method = $this->last->http['method'];

        $response = $this->last->app->$method($this->last->http['url'], $this->last->http['data']);

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

    private function checkExceptions()
    {
        if ($this->last->exception) {
            $this->last->app->expectException($this->last->exception);
        }
    }
}

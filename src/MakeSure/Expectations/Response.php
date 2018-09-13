<?php

namespace Imanghafoori\HeyMan\MakeSure\Expectations;

class Response
{
    private $chain;

    /**
     * Response constructor.
     *
     * @param $chain
     */
    public function __construct($chain)
    {
        $this->chain = $chain;
    }

    public function redirect($url, $status = null)
    {
        $this->assert('assertRedirect', $url);

        if (!is_null($status)) {
            $this->assert('assertStatus', $status);
        }

        return $this;
    }

    public function statusCode($code)
    {
        $this->assert('assertStatus', $code);

        return $this;
    }

    public function success()
    {
        $this->assert('assertSuccessful', null);
    }

    public function withError($value)
    {
        $this->assert('assertSessionHasErrors', $value);

        return $this;
    }

    public function forbiddenStatus()
    {
        return $this->statusCode(403);
    }

    /**
     * @param $value
     * @param $assertion
     */
    private function assert($assertion, $value)
    {
        $this->chain->addAssertion($assertion, $value);
    }
}

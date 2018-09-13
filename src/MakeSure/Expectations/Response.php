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
        $this->assert($url, 'assertRedirect');

        if (!is_null($status)) {
            $this->assert($status, 'assertStatus');
        }

        return $this;
    }

    public function statusCode($code)
    {
        $this->assert($code, 'assertStatus');

        return $this;
    }

    public function success()
    {
        $this->assert(null, 'assertSuccessful');
    }

    public function withError($value)
    {
        $this->assert($value, 'assertSessionHasErrors');

        return $this;
    }

    public function forbiddenStatus()
    {
        return $this->statusCode(403);
    }

    /**
     * @param $url
     * @param $str
     */
    private function assert($url, $str)
    {
        $this->chain->addAssertion($url, $str);
    }
}

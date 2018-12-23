<?php

namespace Imanghafoori\HeyMan\MakeSure\Expectations;

use Imanghafoori\HeyMan\MakeSure\Chain;

class Response
{
    private $chain;

    /**
     * Response constructor.
     *
     * @param $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    public function redirect($url, $status = null)
    {
        $this->addAssertion('assertRedirect', $url);

        if (!is_null($status)) {
            $this->statusCode($status);
        }

        return $this;
    }

    public function statusCode($code)
    {
        $this->addAssertion('assertStatus', $code);

        return $this;
    }

    public function success()
    {
        $this->addAssertion('assertSuccessful');
    }

    public function withError($value)
    {
        $this->addAssertion('assertSessionHasErrors', $value);

        return $this;
    }

    public function forbiddenStatus()
    {
        return $this->statusCode(403);
    }

    /**
     * @param $value
     * @param $type
     */
    public function addAssertion($type, $value = null)
    {
        $this->chain->data['assertion'][] = [$type, $value];
    }
}

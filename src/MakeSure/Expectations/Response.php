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
        $this->chain->assertion[] = ['type' => 'assertRedirect', 'value' => $url];

        if (!is_null($status)) {
            $this->chain->assertion[] = ['type' => 'assertStatus', 'value' => $status];
        }

        return $this;
    }

    public function statusCode($code)
    {
        $this->chain->assertion[] = ['type' => 'assertStatus', 'value' => $code];

        return $this;
    }

    public function success()
    {
        $this->chain->assertion[] = ['type' => 'assertSuccessful', 'value' => null];
    }

    public function withError($value)
    {
        $this->chain->assertion[] = ['type' => 'assertSessionHasErrors', 'value' => $value];

        return $this;
    }

    public function forbiddenStatus()
    {
        return $this->statusCode(403);
    }
}

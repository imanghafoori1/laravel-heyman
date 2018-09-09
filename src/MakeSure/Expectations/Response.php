<?php

namespace Imanghafoori\HeyMan\MakeSure\Expectations;

class Response
{
    private $last;

    /**
     * Response constructor.
     *
     * @param $last
     */
    public function __construct($last)
    {
        $this->last = $last;
    }

    public function redirect($url, $status = null)
    {
        $this->last->assertion[] = ['type' => 'assertRedirect', 'value' => $url];

        if (!is_null($status)) {
            $this->last->assertion[] = ['type' => 'assertStatus', 'value' => $status];
        }

        return $this;
    }

    public function statusCode($code)
    {
        $this->last->assertion[] = ['type' => 'assertStatus', 'value' => $code];

        return $this;
    }

    public function success()
    {
        $this->last->assertion[] = ['type' => 'assertSuccessful', 'value' => null];
    }

    public function withError($value)
    {
        $this->last->assertion[] = ['type' => 'assertSessionHasErrors', 'value' => $value];

        return $this;
    }

    public function forbiddenStatus()
    {
        return $this->statusCode(403);
    }
}

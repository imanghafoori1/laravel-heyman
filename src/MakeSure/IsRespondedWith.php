<?php

namespace Imanghafoori\HeyMan\MakeSure;

class IsRespondedWith
{
    private $last;

    /**
     * IsRespondedWith constructor.
     *
     * @param $last
     */
    public function __construct(HttpClient $last)
    {
        $this->last = $last;
    }

    public function isRespondedWith(): Response
    {
        return new Response($this->last);
    }

    public function isOk()
    {
        $this->last->assertion[] = ['type' => 'assertSuccessful', 'value' => null];
    }
}

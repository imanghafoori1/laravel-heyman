<?php

namespace Imanghafoori\HeyMan\MakeSure;

use Imanghafoori\HeyMan\MakeSure\Expectations\Response;

class IsRespondedWith
{
    private $chain;

    /**
     * IsRespondedWith constructor.
     *
     * @param $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    public function isRespondedWith(): Response
    {
        return new Response($this->chain);
    }

    public function isOk()
    {
        $this->chain->addAssertion('assertSuccessful');
    }
}

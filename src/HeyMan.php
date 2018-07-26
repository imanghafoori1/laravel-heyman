<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\EventHooks;
use Imanghafoori\HeyMan\Hooks\RouteHooks;
use Imanghafoori\HeyMan\Hooks\ViewHooks;

class HeyMan
{

    use EloquentHooks, RouteHooks, ViewHooks, EventHooks;

    private $chain;

    /**
     * HeyMan constructor.
     *
     * @param \Imanghafoori\HeyMan\Chain $chain
     */
    public function __construct(Chain $chain)
    {
        $this->chain = $chain;
    }

    /**
     * @param $url
     *
     * @return array
     */
    private function normalizeInput(array $url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }

    /**
     * @param $value
     *
     * @return YouShouldHave
     */
    private function authorize($value): YouShouldHave
    {
        $this->chain->authorizer = app(ListenerApplier::class)->init($value);

        return app(YouShouldHave::class);
    }

    public function startListening()
    {
        $callbackListener = app(ListenerFactory::class)->make();
        $this->chain->authorizer->startGuarding($callbackListener);
    }
}

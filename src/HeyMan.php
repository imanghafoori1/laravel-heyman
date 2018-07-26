<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\EventHooks;
use Imanghafoori\HeyMan\Hooks\RouteHooks;
use Imanghafoori\HeyMan\Hooks\ViewHooks;
use Imanghafoori\HeyMan\WatchingStrategies\BasicEventManager;

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
     * @param $eventName
     *
     * @return YouShouldHave
     */
    private function holdWhen($eventName): YouShouldHave
    {
        $this->chain->eventManager = app(BasicEventManager::class)->init($eventName);

        return app(YouShouldHave::class);
    }
}

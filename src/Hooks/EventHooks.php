<?php

namespace Imanghafoori\HeyMan\Hooks;

use Imanghafoori\HeyMan\WatchingStrategies\BasicEventManager;
use Imanghafoori\HeyMan\YouShouldHave;

trait EventHooks
{
    /**
     * @param mixed ...$event
     *
     * @return \Imanghafoori\HeyMan\YouShouldHave
     */
    public function whenEventHappens(...$event)
    {
        return $this->holdWhen($this->normalizeInput($event));
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

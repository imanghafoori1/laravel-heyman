<?php

namespace Imanghafoori\HeyMan\Hooks;

use Imanghafoori\HeyMan\WatchingStrategies\EventManager;
use Imanghafoori\HeyMan\YouShouldHave;

trait EventHooks
{
    /**
     * @param mixed ...$event
     *
     * @return YouShouldHave
     */
    public function whenEventHappens(...$event): YouShouldHave
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
        $this->chain->eventManager = app(EventManager::class)->init($eventName);

        return app(YouShouldHave::class);
    }
}

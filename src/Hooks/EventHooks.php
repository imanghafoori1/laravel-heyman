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
        return $this->watchEvents($this->normalizeInput($event));
    }

    /**
     * @param $eventName
     *
     * @return YouShouldHave
     */
    private function watchEvents($eventName): YouShouldHave
    {
        $this->chain->eventManager = app(EventManager::class)->init($eventName, 'listen');

        return app(YouShouldHave::class);
    }
}

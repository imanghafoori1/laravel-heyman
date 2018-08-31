<?php

namespace Imanghafoori\HeyMan\Boot;

use Imanghafoori\HeyMan\Chain;
use Imanghafoori\HeyMan\HeyMan;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;
use Imanghafoori\HeyMan\Normilizers\ViewNormalizer;
use Imanghafoori\HeyMan\Reactions\ReactionFactory;
use Imanghafoori\HeyMan\WatchingStrategies\{EloquentEventsManager, EventManager, RouterEventManager, ViewEventManager};
use Imanghafoori\HeyMan\YouShouldHave;

class Singletons
{
    public static function make($app)
    {
        $singletons = self::singletons();

        foreach ($singletons as $class) {
            $app->singleton($class, $class);
        }
    }

    /**
     * @return array
     */
    private static function singletons(): array
    {
        return [
            HeyManSwitcher::class,
            Chain::class,
            HeyMan::class,
            YouShouldHave::class,
            ReactionFactory::class,
            EventManager::class,
            RouterEventManager::class,
            ViewEventManager::class,
            EloquentEventsManager::class,
            ViewNormalizer::class
        ];
    }
}

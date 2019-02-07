<?php

namespace Imanghafoori\HeyMan\Boot;

use Imanghafoori\HeyMan\Chain;
use Imanghafoori\HeyMan\HeyMan;
use Imanghafoori\HeyMan\YouShouldHave;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;
use Imanghafoori\HeyMan\Reactions\ReactionFactory;
use Imanghafoori\HeyMan\Conditions\ConditionsFacade;
use Imanghafoori\HeyMan\WatchingStrategies\ChainCollection;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventManager;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewEventManager;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentEventsManager;

class Singletons
{
    public static function make($app)
    {
        $singletons = self::singletons();

        foreach ($singletons as $class) {
            $app->singleton($class);
        }
        $app->singleton('heyman.chain', Chain::class);
        $app->singleton('heyman.chains', ChainCollection::class);
    }

    /**
     * @return array
     */
    private static function singletons(): array
    {
        return [
            HeyManSwitcher::class,
            HeyMan::class,
            YouShouldHave::class,
            ReactionFactory::class,
            EventManager::class,
            ViewEventManager::class,
            EloquentEventsManager::class,
            ViewNormalizer::class,
            ConditionsFacade::class,
            Chain::class,
        ];
    }
}

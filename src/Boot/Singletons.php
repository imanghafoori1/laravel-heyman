<?php

namespace Imanghafoori\HeyMan\Boot;

use Imanghafoori\HeyMan\HeyMan;
use Imanghafoori\HeyMan\Core\Chain;
use Imanghafoori\HeyMan\YouShouldHave;
use Imanghafoori\HeyMan\Core\ChainCollection;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;
use Imanghafoori\HeyMan\Reactions\ReactionFactory;
use Imanghafoori\HeyMan\Conditions\ConditionsFacade;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewNormalizer;
use Imanghafoori\HeyMan\WatchingStrategies\Events\EventListeners;
use Imanghafoori\HeyMan\WatchingStrategies\Views\ViewEventListener;
use Imanghafoori\HeyMan\WatchingStrategies\EloquentModels\EloquentEventsListener;

class Singletons
{
    protected static $singletons = [
        HeyManSwitcher::class,
        HeyMan::class,
        YouShouldHave::class,
        ReactionFactory::class,
        EventListeners::class,
        ViewEventListener::class,
        EloquentEventsListener::class,
        ViewNormalizer::class,
        ConditionsFacade::class,
        Chain::class,
    ];

    public static function make($app)
    {
        foreach (self::$singletons as $class) {
            $app->singleton($class);
        }
        $app->singleton('heyman.chain', Chain::class);
        $app->singleton('heyman.chains', ChainCollection::class);
    }
}

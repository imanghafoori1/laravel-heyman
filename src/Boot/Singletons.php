<?php

namespace Imanghafoori\HeyMan\Boot;

use Imanghafoori\HeyMan\Core\Chain;
use Imanghafoori\HeyMan\Core\ChainCollection;
use Imanghafoori\HeyMan\Core\Condition;
use Imanghafoori\HeyMan\Core\ConditionsFacade;
use Imanghafoori\HeyMan\Core\Reaction;
use Imanghafoori\HeyMan\Core\ReactionFactory;
use Imanghafoori\HeyMan\HeyMan;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;

class Singletons
{
    protected static $singletons = [
        Chain::class,
        HeyMan::class,
        Reaction::class,
        Condition::class,
        HeyManSwitcher::class,
        ReactionFactory::class,
        ConditionsFacade::class,
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

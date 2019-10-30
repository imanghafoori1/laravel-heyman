<?php

namespace Imanghafoori\HeyMan\Boot;

use Imanghafoori\HeyMan\HeyMan;
use Imanghafoori\HeyMan\Core\Chain;
use Imanghafoori\HeyMan\Condition;
use Imanghafoori\HeyMan\Core\ChainCollection;
use Imanghafoori\HeyMan\Switching\HeyManSwitcher;
use Imanghafoori\HeyMan\Reactions\ReactionFactory;
use Imanghafoori\HeyMan\Core\ConditionsFacade;

class Singletons
{
    protected static $singletons = [
        HeyManSwitcher::class,
        HeyMan::class,
        Condition::class,
        ReactionFactory::class,
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

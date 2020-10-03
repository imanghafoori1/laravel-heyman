<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Views;

use Imanghafoori\HeyMan\Contracts\ForgettableSituation;

class ViewSituationProvider implements ForgettableSituation
{
    public function getListener()
    {
        return ViewEventListener::class;
    }

    public function getSituationProvider()
    {
        return ViewSituations::class;
    }

    public function getForgetKey()
    {
        return 'viewChecks';
    }

    public function getMethods()
    {
        return [
            'whenYouMakeView',
        ];
    }

    public static function getForgetMethods()
    {
        return ['aboutView'];
    }

    public static function getForgetArgs($method, $args)
    {
        return [ViewEventListener::class, $args];
    }
}

<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

class ViewSituationProvider
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

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return [
            'whenYouMakeView',
        ];
    }
}

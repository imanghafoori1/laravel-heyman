<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

final class ViewSituations
{
    public $listener = ViewEventListener::class;

    public function hasMethod($method)
    {
        return in_array($method, [
            'whenYouMakeView'
        ]);
    }

    /**
     * @param array|string $views
     */
    public function whenYouMakeView(...$views)
    {
        $view = resolve(ViewNormalizer::class)->normalizeView($views);
        resolve('heyman.chains')->init($this->listener, $view);
    }
}

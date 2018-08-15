<?php

namespace Imanghafoori\HeyMan\WatchingStrategies;

class ViewEventManager extends BaseManager
{
    protected $type = 'view';

    public function forgetAboutAll()
    {
        $this->data = [];
    }

    public function register($view, $callback)
    {
        view()->creator($view, $callback[0]);
    }
}

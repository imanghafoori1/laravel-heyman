<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

class ViewEventManager
{
    /**
     * @param $chainData
     */
    public function startWatching($chainData)
    {
        foreach ($chainData as $value => $callbacks) {
            foreach ($callbacks as $key => $cb) {
                view()->creator($value, $cb[0]);
            }
        }

    }
}

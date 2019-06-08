<?php

namespace Imanghafoori\HeyMan\WatchingStrategies\Views;

use Illuminate\Contracts\View\Factory as ViewFactory;

class ViewEventListener
{
    /**
     * @param $chainData
     */
    public function startWatching($chainData)
    {
        foreach ($chainData as $value => $callbacks) {
            foreach ($callbacks as $key => $cb) {
                resolve(ViewFactory::class)->creator($value, $cb[0]);
            }
        }
    }
}

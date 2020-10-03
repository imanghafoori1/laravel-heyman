<?php

namespace Imanghafoori\HeyMan\Plugins\WatchingStrategies\Concerns;

interface ListenToSituation {
    public function startWatching($chainData);
}
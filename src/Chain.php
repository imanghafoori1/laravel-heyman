<?php

namespace Imanghafoori\HeyMan;

class Chain
{
    /**
     * @var \Imanghafoori\HeyMan\ListenerApplier
     */
    public $chainInfo = [
        'beforeReaction' => [],
        'debugInfo' => ['file' => '', 'line' => '', 'args' => ''],
        'condition' => null,
        'termination' => null,
        'eventManager' => null,
        'responseType' => 'nothing',
        'data' => [],
    ];
}
